<?php

use App\Rede;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

use App\Utils\NetworkOps;

$factory->define(App\Equipamento::class, function (Faker $faker) {

    //Busca aleatoriamente um grupo
    $role_user = DB::table('role_user')->inRandomOrder()->first();
    
    //Baseado no grupo ao que usuário pertence, busca-se as redes que estão disponíveis para esse grupo
    $role_rede = DB::table('role_rede')->where('role_id',$role_user->role_id)->inRandomOrder()->first();

    //Aqui retorna-se um collection da rede selecionada aleatoriamente para configuração do equipamento
    $rede = Rede::find($role_rede->rede_id);
        
    // Não começa em zero para excluir gateway
    $ip_selecionado = NetworkOps::getRandomIP($rede->iprede, $rede->cidr);

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
        'user_id' => $role_user->user_id,
    ];
});
