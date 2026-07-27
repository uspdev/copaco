<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // cria campo codpes para senhaunica-socialite
        Schema::table('users', function (Blueprint $table) {
            $table->integer('codpes');
        });

        // Migrando o campo username para codpes apenas dos campos numéricos
        $users = User::whereRaw("username REGEXP '^[0-9]+$'")->get();
        foreach($users as $user){
            $user->codpes = $user->username;
            $user->save();
        }

        // deletando username
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });

        // como não teremos mais roles, vamos mudar a estratégia
        Schema::table('redes', function (Blueprint $table) {
            $table->boolean('onlyadmin')->nullable()->default(true);
        });
        DB::table('redes')->update(['onlyadmin' => true]);

        // deletando tabelas por conta da atualização do senhaunica-socialite
        Schema::dropIfExists('role_rede');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
