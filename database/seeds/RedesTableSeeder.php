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
        $entrada = [
            'nome'      => 'Departamento de Música Clássica',
            'iprede'    => '192.168.0.0',
            'gateway'   => '192.168.0.1',
            'dns'       => '192.168.0.10',
            'ntp'       => '192.168.0.11',
            'netbios'   => '192.168.0.12',
            'cidr'      => '22',
            'vlan'      => '1587',
            'ad_domain' => 'musica.usp.br',
            'user_id'   => '1',
            'shared_network' => 'default',
        ];
        App\Rede::create($entrada);

        factory(App\Rede::class, 10)->create();
    }
}
