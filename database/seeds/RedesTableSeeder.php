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
        factory(App\Rede::class, 30)->create();
    }
}
