<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovosCamposEmEquipamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            //
            $table->boolean('patrimoniado');
            $table->string('patrimonio')->nullable();
            $table->string('descricaonaopatromoniado')->nullable();
            $table->macAddress('macaddress')->unique();
            $table->string('local');
            $table->date('vencimento');
            $table->ipAddress('ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            //
        });
    }
}
