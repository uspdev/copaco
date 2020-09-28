<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Rede;
use App\Models\Equipamento;
use App\Models\Config;

use App\Utils\NetworkOps;
use App\Utils\Utils;

use IPTools\IP;
use IPTools\Network;
use IPTools\Range;

class DhcpController extends Controller
{
    
    /* Geração de dhcp de rede segmentada */
    public function dhcpd(Request $request)
    {
        if($request->consumer_deploy_key != config('copaco.consumer_deploy_key'))
        {
            return response('Unauthorized action.', 403);
        }

        $ops = new NetworkOps;
        $date = Utils::ItensUpdatedAt();

/* Monta header do dhcpd.conf */
        $dhcp_global = Config::where('key','dhcp_global')->first();
        if(is_null($dhcp_global)){
            $dhcp_global = new Config;
            $dhcp_global->value = '';
        }

        $dhcp = <<<HEREDOC
# {$date}
# build success

{$dhcp_global->value}

HEREDOC;

/* Verificamos se tem shared-networks extras cadastradas, em caso negativo
 * vamos colocar tudo na default */
        $shared_network = Config::where('key','shared_network')->first();
        if(empty($shared_network)){
            $redes = Rede::all();
            $dhcp .= <<<HEREDOC

shared-network "default" {
HEREDOC;

            $dhcp .= $this->BuildSharedNetwork($redes);
            $dhcp .= '}';
        }
        else {
            $shared_networks = array_map('trim', explode(',', $shared_network->value));
            if (!in_array("default", $shared_networks)) 
                array_push($shared_networks, "default");

            foreach($shared_networks as $sn){
                $redes = Rede::where('shared_network',$sn)->get();
                if(!$redes->isEmpty()){
                    $dhcp .= <<<HEREDOC

shared-network "{$sn}" {
HEREDOC;
                    $dhcp .= $this->BuildSharedNetwork($redes);
                    $dhcp .= '}';
                }
            }
        }
        return response($dhcp)->header('Content-Type', 'text/plain');
    }


    /* Método auxiliar para construir dhcpd.conf */
    private function BuildSharedNetwork($redes){
        $dhcp = '';
        foreach ($redes as $rede) {
            /* aqui estamos assumindo que o gateway é o primeiro do range
             * não precisa. o servidor de DHCP é esperto */
            $iprede = $rede->iprede;
            $cidr = $rede->cidr;
            $range_begin = NetworkOps::findFirstIP($iprede, $cidr);
            $range_end = NetworkOps::findLastIP($iprede, $cidr);
            $broadcast = NetworkOps::findBroadcast($iprede, $cidr);

            $mask = (string)Network::parse("{$rede->iprede}/{$rede->cidr}")->netmask;


            $dhcp .= <<<HEREDOC

  subnet {$rede->iprede} netmask {$mask} {
    range {$range_begin} {$range_end};
    option routers {$rede->gateway};
    option broadcast-address {$broadcast};

HEREDOC;
            //Opcionais: Netbios, NTP, DNS e Domain (Active Directory)
            if (!empty($rede->netbios)) {
                $dhcp .= <<<HEREDOC
    option netbios-name-servers {$rede->netbios};

HEREDOC;
            }

            if (!empty($rede->ntp)) {
                $dhcp .= <<<HEREDOC
    option ntp-servers {$rede->ntp};

HEREDOC;
            }

            if (!empty($rede->dns)) {
                $dhcp .= <<<HEREDOC
    option domain-name-servers {$rede->dns};

HEREDOC;
            }

            if (!empty($rede->ad_domain)) {
                $dhcp .= <<<HEREDOC
    option domain-name "{$rede->ad_domain}";

HEREDOC;
            }
            $dhcp .= <<<NOWDOC
    {$rede->dhcpd_subnet_options}

NOWDOC;

            $equipamentos = $rede->equipamentos;
            foreach ($equipamentos as $equipamento) {
                $dhcp .= <<<HEREDOC
    host equipamento{$equipamento->id} {
       hardware ethernet {$equipamento->macaddress};
       fixed-address {$equipamento->ip};
    }

HEREDOC;
            }
            $dhcp .= <<<'NOWDOC'
  }

NOWDOC;
        }
        $dhcp .= <<<'NOWDOC'
NOWDOC;
    return $dhcp;
    }


    /* Geração de dhcp para rede sem segmentação */
    public function uniquedhcpd(Request $request)
    {
        if($request->consumer_deploy_key != config('copaco.consumer_deploy_key'))
        {
            return response('Unauthorized action.', 403);
        }

        $iprede = Config::where('key','unique_iprede')->first();
        $gateway = Config::where('key','unique_gateway')->first();
        $cidr = Config::where('key','unique_cidr')->first();

        if(is_null($iprede) || is_null($iprede) || is_null($iprede)) {
            return response('Not allowed. Missing network data', 403);
        }

        $iprede = $iprede->value;
        $gateway = $gateway->value;
        $cidr = $cidr->value;
        $mask = NetworkOps::findNetmask($cidr);
        $broadcast = NetworkOps::findBroadcast($iprede, $cidr);
        $range_begin = NetworkOps::findFirstIP($iprede, $cidr);
        $range_end = NetworkOps::findLastIP($iprede, $cidr);

        $ips_reservados = Config::where('key','ips_reservados')->first();
        if(is_null($ips_reservados)){
            $ips_alocados = [];
        } else {
            $ips_alocados = array_map('trim', explode(',',$ips_reservados->value));
        }

        $ops = new NetworkOps;
        $date = Utils::ItensUpdatedAt();

/* Monta header do dhcpd.conf */
        $dhcp_global = Config::where('key','dhcp_global')->first();
        if(is_null($dhcp_global)){
            $dhcp_global = new Config;
            $dhcp_global->value = '';
        }

        $dhcp = <<<HEREDOC
# {$date}
# build success

{$dhcp_global->value}

HEREDOC;

            $dhcp .= <<<NOWDOC

subnet {$iprede} netmask {$mask} {
  range {$range_begin} {$range_end};
  option routers {$gateway};
  option broadcast-address {$broadcast};


NOWDOC;

        $equipamentos = Equipamento::all();
            foreach ($equipamentos as $equipamento) {
                $ip = NetworkOps::nextIpAvailable($ips_alocados, $iprede, $cidr, $gateway);
                if($ip){
                array_push($ips_alocados, $ip);
                $dhcp .= <<<HEREDOC
    host equipamento{$equipamento->id} {
       hardware ethernet {$equipamento->macaddress};
       fixed-address {$ip};
    }

HEREDOC;
                }
            }

            $dhcp .= <<<NOWDOC
}
NOWDOC;

        return response($dhcp)->header('Content-Type', 'text/plain');
    }
}

