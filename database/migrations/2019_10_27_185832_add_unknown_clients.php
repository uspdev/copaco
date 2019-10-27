<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnknownClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redes', function (Blueprint $table) {
            /* 1 - true */
            $table->boolean('unknown_clients')->default(0)->nullable();
        });
        \DB::statement('UPDATE redes SET unknown_clients=0;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redes', function (Blueprint $table) {
            //
        });
    }
}
