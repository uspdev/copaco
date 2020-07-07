<?php

use Illuminate\Database\Seeder;

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
        App\User::create($entrada);

    }
}
