<?php

use Faker\Generator as Faker;
use App\Utils\NetworkOps;

$factory->define(App\Rede::class, function (Faker $faker) {

    // Seleciona o gateway como o primeiro ip da rede
    $iprede = $faker->unique()->ipv4;
    $cidr = $faker->numberBetween(21, 30);

    // usuários
    $user_create = factory(App\User::class)->create();
    $user_modify = factory(App\User::class)->create();

    return [
        'nome'      => $faker->unique()->numerify('Rede ###'),
        'iprede'    => $iprede,
        'gateway'   => NetworkOps::findFirstIP($iprede, $cidr),
        'dns'       => $faker->ipv4,
        'ntp'       => $faker->ipv4,
        'netbios'   => $faker->domainName,
        'cidr'      => $cidr,
        'vlan'      => $faker->unique()->numberBetween(10, 100),
        'ad_domain' => $faker->domainName,
        //'last_modify_by' => $user_create->id,
        'user_id'   => $user_modify->id,
    ];
});
