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
            'name' => 'Gonzalo Ward',
            'email' => 'alvah.towne@example.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // hash para 'secret'
            'remember_token' => 'tSRgR8J5fT',
            'username' => 'rchristiansen',
        ];
        App\User::create($entrada);

        // 1 user with 2 role
        $role1 = factory(App\Role::class)->create();
        $role2 = factory(App\Role::class)->create();
        $user = factory(App\User::class)->create();
        $user->roles()->attach($role1);
        $user->roles()->attach($role2);

        factory(App\User::class, 30)->create();
    }
}
