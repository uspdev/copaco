<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rede;
use App\Models\Equipamento;
use App\Models\Config;
use App\Utils\NetworkOps;
use App\Utils\Utils;
use IPTools\Network;

class KeaController extends Controller
{
    public function kea(Request $request)
    {
        if ($request->consumer_deploy_key != config('copaco.consumer_deploy_key')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $date = Utils::ItensUpdatedAt();

        $dhcp_global = Config::where('key', 'dhcp_global')->first();
        $globalOptions = $this->parseGlobalOptions($dhcp_global->value ?? '');

        $keaConfig = [
            'Dhcp4' => [
                'interfaces-config' => [
                    'interfaces' => ['*'], // ou defina uma interface específica via config
                ],
                'lease-database' => [
                    'type' => 'memfile',
                    'name' => '/var/lib/kea/kea-leases4.csv',
                ],
                'control-socket' => [
                    'socket-type' => 'unix',
                    'socket-name' => '/tmp/kea4-ctrl-socket',
                ],
                'loggers' => [
                    [
                        'name' => 'kea-dhcp4',
                        'severity' => 'INFO',
                        'output_options' => [
                            [
                                'output' => '/var/log/kea/kea-dhcp4.log',
                            ],
                        ],
                    ],
                ],
                'option-data' => $globalOptions, // opções globais
                'shared-networks' => [],
            ],
        ];

        $sharedNetworkConfig = Config::where('key', 'shared_network')->first();
        if (empty($sharedNetworkConfig)) {
            // Todas as redes com active_dhcp=1 vão para a shared-network "default"
            $redes = Rede::where('active_dhcp', 1)->get();
            if ($redes->isNotEmpty()) {
                $keaConfig['Dhcp4']['shared-networks'][] = $this->buildSharedNetwork('default', $redes);
            }
        } else {
            $sharedNetworksList = array_map('trim', explode(',', $sharedNetworkConfig->value));
            if (!in_array('default', $sharedNetworksList)) {
                $sharedNetworksList[] = 'default';
            }
            foreach ($sharedNetworksList as $sn) {
                $redes = Rede::where('shared_network', $sn)->where('active_dhcp', 1)->get();
                if ($redes->isNotEmpty()) {
                    $keaConfig['Dhcp4']['shared-networks'][] = $this->buildSharedNetwork($sn, $redes);
                }
            }
        }

        return response()->json($keaConfig, 200, ['Content-Type' => 'application/json']);
    }

    private function buildSharedNetwork(string $name, $redes)
    {
        $sharedNetwork = [
            'name' => $name,
            'subnet4' => [],
            'option-data' => [],
        ];

        foreach ($redes as $rede) {
            $subnet = $this->buildSubnet($rede);
            $sharedNetwork['subnet4'][] = $subnet;
        }

        return $sharedNetwork;
    }

    private function buildSubnet(Rede $rede)
    {
        $mask = (string) Network::parse("{$rede->iprede}/{$rede->cidr}")->netmask;
        $subnetCidr = "{$rede->iprede}/{$rede->cidr}";

        $rangeBegin = NetworkOps::findFirstIP($rede->iprede, $rede->cidr);
        $rangeEnd = NetworkOps::findLastIP($rede->iprede, $rede->cidr);
        $broadcast = NetworkOps::findBroadcast($rede->iprede, $rede->cidr);

        $options = [];

        $options[] = [
            'name' => 'routers',
            'data' => $rede->gateway,
        ];
        $options[] = [
            'name' => 'broadcast-address',
            'data' => $broadcast,
        ];
        if (!empty($rede->netbios)) {
            $options[] = [
                'name' => 'netbios-name-servers',
                'data' => $rede->netbios,
            ];
        }
        if (!empty($rede->ntp)) {
            $options[] = [
                'name' => 'ntp-servers',
                'data' => $rede->ntp,
            ];
        }
        if (!empty($rede->dns)) {
            $options[] = [
                'name' => 'domain-name-servers',
                'data' => $rede->dns,
            ];
        }
        if (!empty($rede->ad_domain)) {
            $options[] = [
                'name' => 'domain-name',
                'data' => $rede->ad_domain,
            ];
        }

        if (!empty($rede->dhcpd_subnet_options)) {
            // As opções customizadas vêm como texto bruto (ex: "option ntp-servers 10.0.0.1;")
            // Para Kea, precisamos converter para JSON; aqui simplificamos: ignoramos ou logamos.
            // Se necessário, implemente um parser básico.
        }

        // Reservas de host (equipamentos com IP fixo)
        $reservations = [];
        foreach ($rede->equipamentos as $equip) {
            if (!empty($equip->macaddress) && !empty($equip->ip)) {
                $reservations[] = [
                    'hw-address' => $equip->macaddress,
                    'ip-address' => $equip->ip,
                ];
            }
        }

        $subnet = [
            'subnet' => $subnetCidr,
            'pools' => [
                [
                    'pool' => "{$rangeBegin} - {$rangeEnd}",
                ],
            ],
            'option-data' => $options,
            'reservations' => $reservations,
        ];

        return $subnet;
    }

    /**
     * Converte as opções globais do dhcp_global para o formato Kea option-data
     * Exemplo de entrada: "option domain-name-servers 8.8.8.8;\noption ntp-servers 0.0.0.0;"
     */
    private function parseGlobalOptions($globalConfigText)
    {
        $options = [];
        // Parse simplificado: procura linhas com "option <nome> <valor>;"
        $lines = explode("\n", $globalConfigText);
        foreach ($lines as $line) {
            if (preg_match('/^\s*option\s+([a-z0-9\-]+)\s+(.+?);\s*$/i', $line, $matches)) {
                $name = $matches[1];
                $value = trim($matches[2]);
                $options[] = [
                    'name' => $name,
                    'data' => $value,
                ];
            }
        }
        return $options;
    }

    /**
     * Geração de configuração Kea para rede única (não segmentada)
     * Baseado em uniquedhcpd()
     */
    public function uniquekeab(Request $request)
    {
        if ($request->consumer_deploy_key != config('copaco.consumer_deploy_key')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $iprede = Config::where('key', 'unique_iprede')->first();
        $gateway = Config::where('key', 'unique_gateway')->first();
        $cidr = Config::where('key', 'unique_cidr')->first();

        if (is_null($iprede) || is_null($gateway) || is_null($cidr)) {
            return response()->json(['error' => 'Missing network data'], 403);
        }

        $iprede = $iprede->value;
        $gateway = $gateway->value;
        $cidr = $cidr->value;
        $mask = NetworkOps::findNetmask($cidr);
        $broadcast = NetworkOps::findBroadcast($iprede, $cidr);
        $rangeBegin = NetworkOps::findFirstIP($iprede, $cidr);
        $rangeEnd = NetworkOps::findLastIP($iprede, $cidr);

        $ipsReservadosConfig = Config::where('key', 'ips_reservados')->first();
        $reservedIps = [];
        if ($ipsReservadosConfig) {
            $reservedIps = array_map('trim', explode(',', $ipsReservadosConfig->value));
        }

        $equipamentos = Equipamento::all();
        $reservations = [];
        $ipsAlocados = $reservedIps;
        foreach ($equipamentos as $equip) {
            $ip = NetworkOps::nextIpAvailable($ipsAlocados, $iprede, $cidr, $gateway);
            if ($ip && !empty($equip->macaddress)) {
                $reservations[] = [
                    'hw-address' => $equip->macaddress,
                    'ip-address' => $ip,
                ];
                $ipsAlocados[] = $ip;
            }
        }

        $dhcp_global = Config::where('key', 'dhcp_global')->first();
        $globalOptions = $this->parseGlobalOptions($dhcp_global->value ?? '');

        $keaConfig = [
            'Dhcp4' => [
                'interfaces-config' => ['interfaces' => ['*']],
                'lease-database' => [
                    'type' => 'memfile',
                    'name' => '/var/lib/kea/kea-leases4.csv',
                ],
                'control-socket' => [
                    'socket-type' => 'unix',
                    'socket-name' => '/tmp/kea4-ctrl-socket',
                ],
                'loggers' => [
                    [
                        'name' => 'kea-dhcp4',
                        'severity' => 'INFO',
                        'output_options' => [
                            ['output' => '/var/log/kea/kea-dhcp4.log'],
                        ],
                    ],
                ],
                'option-data' => $globalOptions,
                'subnet4' => [
                    [
                        'subnet' => "{$iprede}/{$cidr}",
                        'pools' => [
                            ['pool' => "{$rangeBegin} - {$rangeEnd}"],
                        ],
                        'option-data' => [
                            ['name' => 'routers', 'data' => $gateway],
                            ['name' => 'broadcast-address', 'data' => $broadcast],
                        ],
                        'reservations' => $reservations,
                    ],
                ],
            ],
        ];

        return response()->json($keaConfig, 200, ['Content-Type' => 'application/json']);
    }
}