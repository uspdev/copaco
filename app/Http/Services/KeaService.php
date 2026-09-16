<?php

namespace App\Http\Services;

use App\Models\Rede;
use App\Models\Equipamento;
use App\Models\Config;
use App\Utils\NetworkOps;
use App\Actions\GenerateIdFromSubnet;

class KeaService
{

     /* Estrutura base do Kea Dhcp4*/

    private function baseConfig(): array
    {
        return [
            'Dhcp4' => [
                'interfaces-config' => [
                    'interfaces' => ['*'], // pode vir de config futuramente
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
                            ['output' => '/var/log/kea/kea-dhcp4.log'],
                        ],
                    ],
                ],
                'option-data' => [], // será preenchido depois
            ],
        ];
    }

    public function generateKeaConfig(): array
    {
        $config = $this->baseConfig();
        $config['Dhcp4']['option-data'] = $this->parseGlobalOptions();

        $sharedNetworkConfig = Config::where('key', 'shared_network')->first();

        if (empty($sharedNetworkConfig)) {
            $redes = Rede::where('active_dhcp', 1)->get();
            if ($redes->isNotEmpty()) {
                $config['Dhcp4']['shared-networks'][] = $this->buildSharedNetwork('default', $redes);
            }
        } else {
            $sharedNetworksList = array_map('trim', explode(',', $sharedNetworkConfig->value));
            if (!in_array('default', $sharedNetworksList)) {
                $sharedNetworksList[] = 'default';
            }
            foreach ($sharedNetworksList as $sn) {
                $redes = Rede::where('shared_network', $sn)->where('active_dhcp', 1)->get();
                if ($redes->isNotEmpty()) {
                    $config['Dhcp4']['shared-networks'][] = $this->buildSharedNetwork($sn, $redes);
                }
            }
        }

        return $config;
    }


    public function generateUniqueKeaConfig(): array
    {
        $config = $this->baseConfig();
        $config['Dhcp4']['option-data'] = $this->parseGlobalOptions();

        $iprede = Config::where('key', 'unique_iprede')->value('value');
        $gateway = Config::where('key', 'unique_gateway')->value('value');
        $cidr = Config::where('key', 'unique_cidr')->value('value');

        if (!$iprede || !$gateway || !$cidr) {
            throw new \Exception('Missing network data for unique configuration');
        }

        $broadcast = NetworkOps::findBroadcast($iprede, $cidr);
        $rangeBegin = NetworkOps::findFirstIP($iprede, $cidr);
        $rangeEnd = NetworkOps::findLastIP($iprede, $cidr);

        // Opções específicas da subnet
        $subnetOptions = [
            ['name' => 'routers', 'data' => $gateway],
            ['name' => 'broadcast-address', 'data' => $broadcast],
        ];

        // Reservas para equipamentos (alocação automática)
        $reservations = $this->buildReservationsForUnique($iprede, $cidr, $gateway);

        $config['Dhcp4']['subnet4'] = [
            [
                'id' => 1,
                'subnet' => "{$iprede}/{$cidr}",
                'pools' => [
                    ['pool' => "{$rangeBegin} - {$rangeEnd}"],
                ],
                'option-data' => $subnetOptions,
                'reservations' => $reservations,
            ],
        ];

        return $config;
    }


    private function buildSharedNetwork(string $name, $redes): array
    {
        $sharedNetwork = [
            'name' => $name,
            'subnet4' => [],
            'option-data' => [], // opções comuns a todas subnets (se houver)
        ];

        foreach ($redes as $rede) {
            $sharedNetwork['subnet4'][] = $this->buildSubnet($rede);
        }

        return $sharedNetwork;
    }

    private function buildSubnet(Rede $rede): array
    {
        $subnetCidr = "{$rede->iprede}/{$rede->cidr}";
        $rangeBegin = NetworkOps::findFirstIP($rede->iprede, $rede->cidr);
        $rangeEnd = NetworkOps::findLastIP($rede->iprede, $rede->cidr);
        $broadcast = NetworkOps::findBroadcast($rede->iprede, $rede->cidr);

        // Opções DHCP para esta subnet
        $options = [
            ['name' => 'routers', 'data' => $rede->gateway],
            ['name' => 'broadcast-address', 'data' => $broadcast],
        ];

        if (!empty($rede->netbios)) {
            $options[] = ['name' => 'netbios-name-servers', 'data' => $rede->netbios];
        }
        if (!empty($rede->ntp)) {
            $options[] = ['name' => 'ntp-servers', 'data' => $rede->ntp];
        }
        if (!empty($rede->dns)) {
            $options[] = ['name' => 'domain-name-servers', 'data' => $rede->dns];
        }
        if (!empty($rede->ad_domain)) {
            $options[] = ['name' => 'domain-name', 'data' => $rede->ad_domain];
        }


        $reservations = [];
        foreach ($rede->equipamentos as $equip) {
            if (!empty($equip->macaddress) && !empty($equip->ip)) {
                $reservations[] = [
                    'hw-address' => $equip->macaddress,
                    'ip-address' => $equip->ip,
                    'hostname'   => 'equipamento' . $equip->id,
                ];
            }
        }

        return [
            'id' => GenerateIdFromSubnet::execute($rede->iprede),
            'subnet' => $subnetCidr,
            'pools' => [
                ['pool' => "{$rangeBegin} - {$rangeEnd}"],
            ],
            'option-data' => $options,
            'reservations' => $reservations,
        ];
    }

    private function buildReservationsForUnique(string $iprede, string $cidr, string $gateway): array
    {
        $reservedIpsConfig = Config::where('key', 'ips_reservados')->first();
        $reservedIps = $reservedIpsConfig ? array_map('trim', explode(',', $reservedIpsConfig->value)) : [];

        $equipamentos = Equipamento::all();
        $reservations = [];
        $ipsAlocados = $reservedIps;

        foreach ($equipamentos as $equip) {
            if (empty($equip->macaddress)) {
                continue;
            }
            $ip = NetworkOps::nextIpAvailable($ipsAlocados, $iprede, $cidr, $gateway);
            if ($ip) {
                $reservations[] = [
                    'hw-address' => $equip->macaddress,
                    'ip-address' => $ip,
                    'hostname'   => 'equipamento' . $equip->id
                ];
                $ipsAlocados[] = $ip;
            }
        }

        return $reservations;
    }

    private function parseGlobalOptions(): array
    {
        $dhcpGlobal = Config::where('key', 'dhcp_global')->first();
        if (!$dhcpGlobal || empty($dhcpGlobal->value)) {
            return [];
        }

        $options = [];
        $lines = explode("\n", $dhcpGlobal->value);
        foreach ($lines as $line) {
            if (preg_match('/^\s*option\s+([a-z0-9\-]+)\s+(.+?);\s*$/i', $line, $matches)) {
                $options[] = [
                    'name' => $matches[1],
                    'data' => trim($matches[2]),
                ];
            }
        }
        return $options;
    }
}
