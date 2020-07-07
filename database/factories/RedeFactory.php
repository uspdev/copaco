<?php

use Faker\Generator as Faker;
use App\Utils\NetworkOps;

$factory->define(App\Rede::class, function (Faker $faker) {

    // Seleciona o gateway como o primeiro ip da rede
    $redes = ['10.0.0.0', '20.0.0.0', '30.0.0.0', '40.0.0.0', '50.0.0.0', '60.168.0.0', '70.0.0.0', '80.0.0.0', '90.0.0.0', '100.0.0.0', '110.0.0.0'];
    $iprede = $redes[array_rand($redes)];
    $cidr = $faker->numberBetween(21, 30);

    // usuários
    $user_modify = App\User::get("id")->toArray();
    //$user_modify = ['1','2','3','4','5'];

    return [
        'nome'      => $faker->unique()->domainWord() . " network",
        'iprede'    => $iprede,
        'gateway'   => NetworkOps::findFirstIP($iprede, $cidr),
        'dns'       => NetworkOps::getRandomIP($iprede, $cidr),
        'ntp'       => NetworkOps::getRandomIP($iprede, $cidr),
        'netbios'   => NetworkOps::getRandomIP($iprede, $cidr),
        'cidr'      => $cidr,
        'vlan'      => $faker->unique()->numberBetween(10, 100),
        'ad_domain' => $faker->domainName,
        'user_id'   => $user_modify[array_rand($user_modify)]['id'],
        'shared_network' => 'default',
    ];
});
