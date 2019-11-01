<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShared extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redes', function (Blueprint $table) {
            $table->string('shared_network')->nullable();
        });
        \DB::statement("UPDATE redes SET shared_network='default';");
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
