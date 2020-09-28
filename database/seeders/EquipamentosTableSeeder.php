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
            'naopatrimoniado' => 0,
            'patrimonio' => null,
            'descricaosempatrimonio' => 'Computador do Prof. Joel',
            'macaddress' => '00:55:44:88:78:77',
            'local' => 'Sala 10',
            'vencimento' => '2020-07-11',
            'fixarip' => 1,
            'ip' => '192.168.0.22',
            'rede_id' => '16',
            'user_id'   => '1',
        ];
        Equipamento::create($entrada);

        Equipamento::factory(20)->create();
    }
}
