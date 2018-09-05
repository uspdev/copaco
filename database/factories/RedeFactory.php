<?php

use Faker\Generator as Faker;

$factory->define(App\Rede::class, function (Faker $faker) {
    return [
        'nome'      => $faker->unique()->numerify('Rede ###'),
        'iprede'    => $faker->unique()->ipv4,
        'gateway'   => $faker->ipv4,
        'dns'       => $faker->ipv4,
        'ntp'       => $faker->ipv4,
        'netbios'   => $faker->domainName,
        'cidr'      => $faker->numberBetween(21,30),
        'vlan'      => $faker->unique()->numberBetween(10,100),
        'ad_domain' => $faker->domainName,
#        'last_modify_by' => ,
#        'user_id'   => 
    ];
});
