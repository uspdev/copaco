<?php

use Illuminate\Database\Seeder;

class RedesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");
        DB::table('redes')->insert([
            [
              'nome' => 'Rede Secretaria',
              'iprede' => '192.168.1.0',
              'cidr' => 28,
              'gateway' => '192.168.1.1',
              'dns' => '192.168.1.10',
              'ntp' => 'ntp.usp.br',
              "created_at" => $now,
              "updated_at" => $now,
            ],
            [
                'nome' => 'Rede Biblioteca',
                'iprede' => '172.16.1.0',
                'cidr' => 28,
                'gateway' => '172.16.1.1',
                'dns' => '172.16.1.10',
                'ntp' => 'lib.usp.br',
                "created_at" => $now,
                "updated_at" => $now,
              ],
        ]);
    }
}
