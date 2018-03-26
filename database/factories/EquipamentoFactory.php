<?php

use App\Rede;
use Faker\Generator as Faker;

$factory->define(App\Equipamento::class, function (Faker $faker) {
    return [
        'naopatrimoniado' => false,
        'patrimonio' => null,
        'descricaosempatrimonio' => $faker->paragraph(1),
        'macaddress' => $faker->unique()->macAddress,
        'local' => $faker->word,
        'vencimento' => $faker->date(),
        'ip' => $faker->ipv4,

        'rede_id' => function() {
            return Rede::orderByRaw("RAND()")
                ->take(1)
                ->first()
                ->id;
        }
    ];
});
