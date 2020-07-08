<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entrada = [
            'nome' => 'Escola de Música',
        ];
        App\Role::create($entrada);

        factory(App\Role::class, 5)->create()->each(function ($role) {           
            $users = factory(App\User::class, 5)->make();
            $role->users()->saveMany($users);

            $redes = factory(App\Rede::class, 3)->make();
            $role->redes()->saveMany($redes);
        });
    }
}
