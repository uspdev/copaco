<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rede;
use App\Equipamento;
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
            // não precisa. o servidor de DHCP é esperto
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
    {$rede->dhcpd_subnet_options};

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
