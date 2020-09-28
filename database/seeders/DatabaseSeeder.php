<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            RedesTableSeeder::class,
            EquipamentosTableSeeder::class,
            ConfigsTableSeeder::class,
        ]);
    }
}
