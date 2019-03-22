<?php

namespace App\Utils;
use IPTools\IP;
use IPTools\Network;
use IPTools\Range;

use App\Rede;
use App\Equipamento;

class NetworkOps
{
    public static function pertenceRede($ip, $iprede, $cidr)
    {
        $broadcast = ip2long(NetworkOps::findBroadcast($iprede, $cidr));
        $rede = ip2long($iprede);
        if ($rede < ip2long($ip) and ip2long($ip) < $broadcast) {
            return true;
        }
        return false;
    }

    public static function findNetmask($cidr)
    {
        return long2ip(~0 << (32-$cidr));
    }

    public static function findBroadcast($iprede, $cidr)
    {
        $netmask = ip2long(NetworkOps::findNetmask($cidr));
        $rede = ip2long($iprede);
        return long2ip($rede ^ ~$netmask);
    }

    public static function findFirstIP($iprede, $cidr)
    {
        if ($cidr > 30) {
            return false;
        }
        return long2ip(ip2long($iprede)+1);
    }

    public static function findLastIP($iprede, $cidr)
    {
        if ($cidr > 30) {
            return false;
        }
        $broadcast = ip2long(NetworkOps::findBroadcast($iprede, $cidr));
        return long2ip($broadcast-1);
    }

    public static function getRandomIP($iprede, $cidr)
    {
        $min = ip2long($iprede);
        $max = ip2long(NetworkOps::findBroadcast($iprede, $cidr));
        return long2ip(rand($min+1, $max-1));
    }

    public static function nextIpAvailable($ips_alocados, $iprede, $cidr, $gateway)
    {
        /* guarda o gateway e os IPs em forma numérica */
        $ips_numericos = array();
        array_push($ips_numericos, ip2long($gateway));
        foreach($ips_alocados as $ip) {
            array_push($ips_numericos, ip2long($ip));
        }
        sort($ips_numericos);

        /* guarda os limites da rede em forma numérica */
        $min = ip2long($iprede);
        $max = ip2long(NetworkOps::findBroadcast($iprede, $cidr));

        for ($ip = $min+1; $ip < $max; $ip++) {
            if (!in_array($ip, $ips_numericos)) {
                return long2ip($ip);
            }
        }

        return false;
    }

    public static function isIpAvailable(Rede $rede, $ip)
    {
        $ips_alocados = $rede->equipamentos->pluck('ip')->all();
        if (in_array($ip, $ips_alocados)) {
            return false;
        } else {
            return true;
        }
    }

    public function aloca($rede_id, $ip)
    {
        $danger = '';

        if (empty($ip)) {
            $ip = null;
        }
        if (empty($rede_id)) {
            $rede_id = null;
        }

        if (!is_null($rede_id)) {
            $rede = Rede::find($rede_id);
        } else {
            $rede = null;
        }

        // 1 - aloca ip automaticamente, caso um não seja especificado
        if (is_null($ip) && !is_null($rede)) {
            $ips_alocados = $rede->equipamentos->pluck('ip')->all();

            if (is_null($ips_alocados)) {
                $ips_alocados = [];
            }

            $ip = NetworkOps::nextIpAvailable($ips_alocados, $rede->iprede, $rede->cidr, $rede->gateway);

            if ($ip === false) {
                $danger = 'Acabaram os IPs dessa rede, equipamento não alocado!';
                $ip = null;
                $rede_id = null;
            }
        }

        // 2 - quando um ip é especificado e uma rede não
        if (!is_null($ip) && is_null($rede)) {
            $ip = null;
            $danger = 'Rede não especificada, equipamento não alocado.';
        }

        // 3 - quando um ip e uma rede são especificados
        if (!is_null($ip) && !is_null($rede)) {
            # ip pertence a rede?
            if (!NetworkOps::pertenceRede($ip, $rede->iprede, $rede->cidr)) {
                $danger = 'O IP não pertence à rede selecionada. Equipamento não alocado.';
                $ip = null;
                $rede_id = null;
            } else {
                # verificar se ip está disponível
                if (!NetworkOps::isIpAvailable($rede, $ip)) {
                    $danger = 'IP não disponível na rede selecionada. Equipamento não alocado.';
                    $ip = null;
                    $rede_id = null;
                }
            }
        }
        return ['rede'=>$rede_id, 'ip'=>$ip, 'danger' => $danger];
    }
}
