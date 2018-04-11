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
            $table->boolean('naopatrimoniado')->default(0);
            $table->string('patrimonio')->nullable();
            $table->string('descricaosempatrimonio')->nullable();
            $table->macAddress('macaddress')->unique();
            $table->string('local')->nullable();
            $table->date('vencimento');
            $table->ipAddress('ip')->nullable();
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
            /* Não está funfando o refresh
            $table->dropColumn('naopatrimoniado');
            $table->dropColumn('patrimonio');
            $table->dropColumn('descricaosempatrimonio');
            $table->dropColumn('macaddress');
            $table->dropColumn('local');
            $table->dropColumn('vencimento');
            $table->dropColumn('ip');
             */
        });
    }
}
