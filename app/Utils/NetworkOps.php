<?php

namespace App\Utils;

use IPTools\IP;
use IPTools\Network;
use IPTools\Range;

class NetworkOps
{
    // Um método que recebe o ip e cidr da rede e retorna um array com todos ips da mesma
    public function getRange($iprede,$cidr)
    {
        $ips = [];
        $hosts = Network::parse("{$iprede}/{$cidr}")->hosts;
        foreach ($hosts as $ip) {
            array_push($ips, (string)$ip);
        }
        return $ips; 
    }

    public function nextIpAvailable($ips_alocados, $iprede, $cidr, $gateway)
    {
       $ips = $this->getRange($iprede,$cidr); 
       $ips = array_diff($ips,[$gateway]); 

        foreach ($ips as $ip) {
            if (!in_array((string)$ip, $ips_alocados)) {
                return (string)$ip;
            }
        }
        return false;
    }
   
}
