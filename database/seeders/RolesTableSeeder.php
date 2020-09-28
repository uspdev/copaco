<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Rede;

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
        Role::create($entrada);

        Role::factory(5)->create()->each(function ($role) {           
            $users = User::factory(5)->make();
            $role->users()->saveMany($users);

            $redes = Rede::factory(3)->make();
            $role->redes()->saveMany($redes);
        });
    }
}
