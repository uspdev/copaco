<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rede;
use App\Equipamentos;
use App\Config;

use App\Utils\NetworkOps;
use App\Utils\Utils;

use IPTools\IP;
use IPTools\Network;
use IPTools\Range;

class DhcpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['dhcpd']);
    }

    public function dhcpd(Request $request)
    {
        if($request->consumer_deploy_key != config('copaco.consumer_deploy_key'))
        {
            return response('Unauthorized action.', 403);
        }

        $ops = new NetworkOps;
        $date = Utils::ItensUpdatedAt();

        $dhcp_global = Config::where('key','dhcp_global')->first();
        if(is_null($dhcp_global)){
            $dhcp_global = new Config;
            $dhcp_global->value = '';
        }

        $dhcp = <<<HEREDOC
# {$date}
# build success
{$dhcp_global->value}
shared-network "default" {

HEREDOC;

        $redes = Rede::all();
        foreach ($redes as $rede) {
            // aqui estamos assumindo que o gateway é o primeiro do range
            $ips = $ops->getRange($rede->iprede, $rede->cidr, true);
            $range_begin = $ips[2];
            $range_end = $ips[count($ips)-2];
            $broadcast = end($ips);

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

            $dhcp .= <<<'NOWDOC'
    deny unknown-clients;

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
}
NOWDOC;
        return response($dhcp)->header('Content-Type', 'text/plain');
    }
}
