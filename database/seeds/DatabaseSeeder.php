<?php

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
        echo "Criando 10 redes...\n";
        factory(App\Rede::class, 10)->create();

        echo "Criando 30 equipamentos...\n";
        factory(App\Equipamento::class, 30)->create();

        echo "Pronto.";
    }
}
