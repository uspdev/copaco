<?php

use Illuminate\Database\Seeder;

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
            'naopatrimoniado' => true,
            'patrimonio' => null,
            'descricaosempatrimonio' => 'Computador do Prof. Joel',
            'macaddress' => '00:55:44:88:78:77',
            'local' => 'Sala 10',
            'vencimento' => '2020-07-11',
            'fixarip' => 1,
            'ip' => '192.168.0.22',
            'rede_id' => '1',
            'user_id'   => '1',
        ];
        App\Equipamento::create($entrada);

        factory(App\Equipamento::class, 30)->create();
    }
}
