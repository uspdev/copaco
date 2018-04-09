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
        echo "Criando 10 redes..." . PHP_EOL;
        factory(App\Rede::class, 10)->create();

        echo "Criando 30 equipamentos...". PHP_EOL;
        factory(App\Equipamento::class, 30)->create();

        echo "Pronto." . PHP_EOL;
    }
}
