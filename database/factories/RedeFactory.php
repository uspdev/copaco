<?php

use Faker\Generator as Faker;

$factory->define(App\Rede::class, function (Faker $faker) {
    return [
        'nome'      => $faker->unique()->numerify('Rede ###'),
        'iprede'    => $faker->unique()->ipv4,
        'gateway'   => $faker->ipv4,
        'cidr'      => $faker->numberBetween(2,31)
    ];
});
