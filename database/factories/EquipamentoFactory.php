<?php

use App\Rede;
use Faker\Generator as Faker;

use App\Utils\NetworkOps;

$factory->define(App\Equipamento::class, function (Faker $faker) {

    // Cria uma rede e seleciona um ip aleatoriamente da mesma
    $rede = factory(App\Rede::class)->create();

    // Não começa em zero para excluir gateway
    $ip_selecionado = NetworkOps::getRandomIP($rede->iprede, $rede->cidr);

    // usuários
    $user_create = factory(App\User::class)->create();
    $user_modify = factory(App\User::class)->create();

    // fixar IPs
    $fixarip = $faker->boolean();
    if(!$fixarip){
        $ip_selecionado = null;
        $rede->id = null;
    }

    return [
        'naopatrimoniado' => 0,
        'patrimonio' => null,
        'descricaosempatrimonio' => $faker->paragraph(1),
        'macaddress' => $faker->unique()->macAddress,
        'local' => $faker->word,
        'vencimento' => date("Y-m-d", strtotime("+".rand(30, 360)."days")),
        'fixarip' => $fixarip,
        'ip' => $ip_selecionado,
        'rede_id' => $rede->id,
        'user_id'   => $user_modify->id,
    ];
});
