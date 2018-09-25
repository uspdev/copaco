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
        factory(App\User::class, 30)->create();

        // 1 user with 2 role
        $role1 = factory(App\Role::class)->create();
        $role2 = factory(App\Role::class)->create();
        $user = factory(App\User::class)->create();
        $user->roles()->attach($role1);
        $user->roles()->attach($role2);
    }
}
