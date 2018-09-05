<?php

use App\Rede;
use Faker\Generator as Faker;

use App\Utils\NetworkOps;

$factory->define(App\Equipamento::class, function (Faker $faker) {

    // Cria uma rede e seleciona um ip aleatoriamente da mesma
    $rede = factory(App\Rede::class)->create();
    $op = new NetworkOps;
    $ips = $op->getRange($rede->iprede, $rede->cidr);
    $ip_selecionado = $ips[rand(0, count($ips)-1)];

    return [
        'naopatrimoniado' => true,
        'patrimonio' => null,
        'descricaosempatrimonio' => $faker->paragraph(1),
        'macaddress' => $faker->unique()->macAddress,
        'local' => $faker->word,
        'vencimento' => date("Y-m-d H:i:s", strtotime("+".rand(30, 360)."days")),
        'ip' => $ip_selecionado,
        'rede_id' => $rede->id
    ];
});
