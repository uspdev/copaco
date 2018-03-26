<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rede;
use App\Equipamentos;

use App\Utils\NetworkOps;

use IPTools\IP;
use IPTools\Network;
use IPTools\Range;


class DhcpController extends Controller
{
    public function dhcpd()
    {
        $ops = new NetworkOps;

        $dhcp = "ddns-update-style none;\n";
        $dhcp .= "default-lease-time 86400;\n";
        $dhcp .= "max-lease-time 86400;\n";
        $dhcp .= "authoritative;\n";
        $dhcp .= "option domain-name-servers 143.107.253.3,143.107.253.5;\n";
        $dhcp .= "shared-network \"default\" {\n\n";

        $redes = Rede::all(); 
        foreach($redes as $rede){

            $ips = $ops->getRange($rede->iprede,$rede->cidr);
            $range_begin = $ips[1]; 
            $range_end = $ips[count($ips)-2];
            $broadcast = end($ips);

            $mask = (string)Network::parse("{$rede->iprede}/{$rede->cidr}")->netmask;


            $dhcp .= "  subnet {$rede->iprede} netmask {$mask} {\n";
            $dhcp .= "    range {$range_begin} {$range_end}; \n";
            $dhcp .= "    option routers {$rede->gateway}; \n";
            $dhcp .= "    option broadcast-address {$broadcast}; \n";
            $dhcp .= "    deny unknown-clients; \n";

            $equipamentos = $rede->equipamentos;
            foreach($equipamentos as $equipamento) {
                $dhcp .= "      host equipamento{$equipamento->id} {\n";
                $dhcp .= "        hardware ethernet {$equipamento->macaddress};\n";
                $dhcp .= "        fixed-address {$equipamento->ip};\n";
                $dhcp .= "      }\n";
            }
            $dhcp .= "  }\n";
        }
        $dhcp .= "}";
        return response($dhcp)->header('Content-Type', 'text/plain');
    }
}
