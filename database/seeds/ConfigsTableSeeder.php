<?php

use Illuminate\Database\Seeder;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'created_at' => '2020-07-03 14:40:53',
            'updated_at' => '2020-07-03 14:40:53',
            'key' => 'dhcp_global',
            'value' => 'ddns-update-style none;
            default-lease-time 86400;
            max-lease-time 86400;
            authoritative;',
        ]);
        DB::table('configs')->insert([
            'created_at' => '2020-07-03 14:40:53',
            'updated_at' => '2020-07-03 14:40:53',
            'key' => 'shared_network',
            'value' => 'pro-aluno',
        ]);
        DB::table('configs')->insert([
            'created_at' => '2020-07-03 14:40:53',
            'updated_at' => '2020-07-03 14:40:53',
            'key' => 'unique_iprede',
            'value' => '190.0.0.0',
        ]);
        DB::table('configs')->insert([
            'created_at' => '2020-07-03 14:40:53',
            'updated_at' => '2020-07-03 14:40:53',
            'key' => 'unique_gateway',
            'value' => '190.0.0.1',
        ]);
        DB::table('configs')->insert([
            'created_at' => '2020-07-03 14:40:53',
            'updated_at' => '2020-07-03 14:40:53',
            'key' => 'unique_cidr',
            'value' => '24',
        ]);
        DB::table('configs')->insert([
            'created_at' => '2020-07-03 14:40:53',
            'updated_at' => '2020-07-03 14:40:53',
            'key' => 'ips_reservados',
            'value' => '190.0.0.10',
        ]);
    }
}
