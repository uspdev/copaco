<?php

use Illuminate\Database\Seeder;

class DevUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");
        $pass = str_random(40);
        $dev_id = random_int(1000000, 9999999);
        
        echo "Seu developer id é: " . $dev_id . PHP_EOL;
        echo "Configure-o em seu arquivo .env" . PHP_EOL;

        DB::table('users')->insert(
            [
                'id' => $dev_id,
                'name' => 'Developer',
                'email' => 'dev@usp.br',
                'password' => bcrypt($pass),
                "created_at" => $now,
                "updated_at" => $now,
            ]
        );
    }
}
