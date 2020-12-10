<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipamento;
class EquipamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entrada = [
            'patrimonio' => null,
            'descricao' => 'Computador do Prof. Joel',
            'macaddress' => '01:55:44:88:78:77',
            'local' => 'Sala 10',
            'vencimento' => '25/11/2022',
            'ip' => '192.168.0.10',
            'rede_id' => '16',
            'user_id'   => '1',
        ];
        Equipamento::create($entrada);
        Equipamento::factory(20)->create();
    }
}
