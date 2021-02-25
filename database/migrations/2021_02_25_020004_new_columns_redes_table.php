<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewColumnsRedesTable extends Migration
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
            $table->boolean('active_dhcp')->default(1)->nullable();
            $table->boolean('active_freeradius')->default(1)->nullable();
        });
        \DB::statement('UPDATE redes SET active_dhcp=1;');
        \DB::statement('UPDATE redes SET active_freeradius=1;');
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
