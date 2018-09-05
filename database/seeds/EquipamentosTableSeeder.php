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
        factory(App\Equipamento::class, 30)->create();
    }
}
