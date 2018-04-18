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
        $now = date("Y-m-d H:i:s");
        $vencimento = date("Y-m-d H:i:s", strtotime("+30 days"));
        DB::table('equipamentos')->insert([
            # Para a rede 1 - Rede Secretaria
            [
                'naopatrimoniado' => true,
                'patrimonio' => null,
                'descricaosempatrimonio' => "Computador Secretaria",
                'macaddress' => '6b:2e:ad:a3:b3:c4',
                'local' => 'Seção de Pós Graduação',
                'vencimento' => $vencimento,
                'ip' => '192.168.0.2',
                'fixarip' => true,
                'rede_id' => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                'naopatrimoniado' => false,
                'patrimonio' => '123.004200',
                'descricaosempatrimonio' => null,
                'macaddress' => '9c:35:6d:17:25:fa',
                'local' => 'Sala de Reuniões',
                'vencimento' => $vencimento,
                'ip' => '192.168.0.3',
                'fixarip' => true,
                'rede_id' => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                'naopatrimoniado' => false,
                'patrimonio' => '042.060700',
                'descricaosempatrimonio' => null,
                'macaddress' => '8b:ea:94:28:cb:cb',
                'local' => 'Guichê Secretaria',
                'vencimento' => $vencimento,
                'ip' => '192.168.0.4',
                'fixarip' => true,
                'rede_id' => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            # Para a rede 2 - Biblioteca
            [
                'naopatrimoniado' => false,
                'patrimonio' => '172.16000',
                'descricaosempatrimonio' => null,
                'macaddress' => 'a1:0e:c3:0c:22:70',
                'local' => 'Sala de Estudos',
                'vencimento' => $vencimento,
                'ip' => '172.16.0.2',
                'fixarip' => true,
                'rede_id' => 2,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                'naopatrimoniado' => true,
                'patrimonio' => null,
                'descricaosempatrimonio' => 'Computador Pesquisa Biblioteconomia 1',
                'macaddress' => '89:01:c1:2f:20:da',
                'local' => 'Laboratório Ciencia Informação Documentação',
                'vencimento' => $vencimento,
                'ip' => '172.16.0.3',
                'fixarip' => true,
                'rede_id' => 2,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                'naopatrimoniado' => true,
                'patrimonio' => null,
                'descricaosempatrimonio' => 'Computador Pesquisa Biblioteconomia 2',
                'macaddress' => 'bc:65:43:30:9c:fd',
                'local' => 'Laboratório Ciencia Informação Documentação',
                'vencimento' => $vencimento,
                'ip' => '172.16.0.4',
                'fixarip' => true,
                'rede_id' => 2,
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }
}
