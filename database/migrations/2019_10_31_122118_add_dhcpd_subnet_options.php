<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDhcpdSubnetOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redes', function (Blueprint $table) {
            $table->text('dhcpd_subnet_options')->nullable();
        });
        \DB::statement("UPDATE redes SET dhcpd_subnet_options='deny unknown-clients;';");
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
