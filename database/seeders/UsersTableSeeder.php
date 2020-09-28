<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entrada = [
            'name' => 'Fulano da Silva',
            'email' => 'fulano.silva@brasil.com',
            'password' => bcrypt('secret'), // hash para 'secret'
            'username' => 'fulano',
        ];
        User::create($entrada);

    }
}
