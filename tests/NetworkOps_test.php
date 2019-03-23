<?php

namespace App\Utils;

require_once('../app/Utils/NetworkOps.php');
require_once('../vendor/s1lentium/iptools/src/PropertyTrait.php');
require_once('../vendor/s1lentium/iptools/src/IP.php');
require_once('../vendor/s1lentium/iptools/src/Network.php');
require_once('../vendor/s1lentium/iptools/src/Range.php');

# testes
function avalia($esperado, $obtido) {
    $resultado = "passou";
    if ($esperado != $obtido) {
        $resultado = "\e[1;37;41mreprovou\e[0m.\n".
                     "  esperado: ".$esperado."\n".
                     "  obtido: ".$obtido;
    }
    return $resultado;
}

function testa_nextip($nome, $esperado, $ips, $rede, $cidr, $gw) {
    $obtido = NetworkOps::nextIpAvailable($ips, $rede, $cidr, $gw);
    $resultado = avalia($esperado, $obtido);
    echo "teste ".$nome.": ".$resultado."\n";
}

function testaPertenceRede($nome, $esperado, $ip, $iprede, $cidr) {
    $obtido = NetworkOps::pertenceRede($ip, $iprede, $cidr);
    $resultado = avalia($esperado, $obtido);
    echo "teste ".$nome.": ".$resultado."\n";
}

function testaFindNetmask($nome, $esperado, $cidr) {
    $obtido = NetworkOps::findNetmask($cidr);
    $resultado = avalia($esperado, $obtido);
    echo "teste ".$nome.": ".$resultado."\n";
}

function testaFindBroadcast($nome, $esperado, $iprede, $cidr) {
    $obtido = NetworkOps::findBroadcast($iprede, $cidr);
    $resultado = avalia($esperado, $obtido);
    echo "teste ".$nome.": ".$resultado."\n";
}

# ela dá o primeiro ip?
echo "### nextip ###\n";
$ips = [];
$rede = "192.168.0.0"; #sempre será
$cidr = 24;
$gw = "192.168.0.254";
$esperado = "192.168.0.1";
testa_nextip("primeiro ip", $esperado, $ips, $rede, $cidr, $gw)."\n";

# quando tem dois buracos, devolve o menor?
$ips = ["192.168.0.1", "192.168.0.3", "192.168.0.5"];
$cidr = 24;
$gw = "192.168.0.254";
$esperado = "192.168.0.2";
testa_nextip("dois buracos", $esperado, $ips, $rede, $cidr, $gw)."\n";

# quando não tem buraco, devolve o próximo?    
$ips = ["192.168.0.1", "192.168.0.2"];
$cidr = 24;
$gw = "192.168.0.254";
$esperado = "192.168.0.3";
testa_nextip("sem buracos", $esperado, $ips, $rede, $cidr, $gw)."\n";

# o que devolve se não houver IP?
$ips = ["192.168.0.1"];
$cidr = 30;
$gw = "192.168.0.2";
$esperado = false;
testa_nextip("lotado", $esperado, $ips, $rede, $cidr, $gw)."\n";

# o que acontece qdo $cidr > 30?
$ips = [];
$cidr = 31;
$gw = "192.168.0.1";
$esperado = false;
testa_nextip("cidr > 30", $esperado, $ips, $rede, $cidr, $gw)."\n";

# o que acontece se gw está fora da rede?
$ips = [];
$cidr = 25;
$gw = "192.168.0.254";
$esperado = false;
testa_nextip("gw fora da rede", $esperado, $ips, $rede, $cidr, $gw)."\n";

# o que acontece se o ip do gw está na relação de alocados?
$ips = ["192.168.0.1", "192.168.0.2"];
$cidr = 29;
$gw = "192.168.0.1";
$esperado = "192.168.0.3";
testa_nextip("gw alocado", $esperado, $ips, $rede, $cidr, $gw)."\n";

# ignorou o ip do gateway?
$ips = ["192.168.0.2"];
$cidr = 24;
$gw = "192.168.0.1";
$esperado = "192.168.0.3";
testa_nextip("ignorou gw", $esperado, $ips, $rede, $cidr, $gw)."\n";

# demora para um /18? (caso do IME)
$ips = file('./ip_example', FILE_IGNORE_NEW_LINES);
$rede = "192.168.0.0";
$cidr = 18;
$gw = "192.168.45.1";
$esperado = "192.168.0.1";
testa_nextip("/18", $esperado, $ips, $rede, $cidr, $gw)."\n";

echo "\n\n### pertencerede ###\n";
$ip = "192.168.0.1";
$iprede = "192.168.0.0";
$cidr = 24;
$esperado = true;
testaPertenceRede("T 192.168.0.1 em 192.168.0.0/24", $esperado, $ip, $iprede, $cidr);

$ip = "192.168.1.1";
$iprede = "192.168.0.0";
$cidr = 24;
$esperado = false;
testaPertenceRede("F 192.168.1.1 em 192.168.0.0/24", $esperado, $ip, $iprede, $cidr);

$ip = "192.168.0.1";
$iprede = "192.168.1.0";
$cidr = 24;
$esperado = false;
testaPertenceRede("F 192.168.0.1 em 192.168.1.0/24", $esperado, $ip, $iprede, $cidr);

$ip = "192.168.1.1";
$iprede = "192.168.0.0";
$cidr = 23;
$esperado = true;
testaPertenceRede("T 192.168.1.1 em 192.168.0.0/23", $esperado, $ip, $iprede, $cidr);

$ip = "192.168.0.1";
$iprede = "192.168.0.0";
$cidr = 32;
$esperado = false;
testaPertenceRede("F 192.168.0.0 em 192.168.0.0/32", $esperado, $ip, $iprede, $cidr);

echo "\n\n### findnetmask ###\n";
$cidr = 0;
$esperado = "0.0.0.0";
testaFindNetmask("cidr 0", $esperado, $cidr);

$cidr = 32;
$esperado = "255.255.255.255";
testaFindNetmask("cidr 32", $esperado, $cidr);

$cidr = 18;
$esperado = "255.255.192.0";
testaFindNetmask("cidr 18", $esperado, $cidr);

echo "\n\n### findbroadcast ###\n";
$iprede = "192.168.0.0";
$cidr = 24;
$esperado = "192.168.0.255";
testaFindBroadcast("192.168.0.0/24", $esperado, $iprede, $cidr);

$iprede = "10.0.0.0";
$cidr = 18;
$esperado = "10.0.63.255";
testaFindBroadcast("10.0.0.0/18", $esperado, $iprede, $cidr);

$iprede = "192.168.0.0";
$cidr = 31;
$esperado = "192.168.0.1";
testaFindBroadcast("192.168.0.0/31", $esperado, $iprede, $cidr);

