<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('naopatrimoniado')->default(0);
            $table->string('patrimonio')->nullable();
            $table->string('descricaosempatrimonio')->nullable();
            $table->macAddress('macaddress')->unique();
            $table->string('local')->nullable();
            $table->date('vencimento');
            $table->boolean('fixarip')->default(0);
            $table->ipAddress('ip')->nullable();
            $table->integer('rede_id')->unsigned()->nullable();
            $table->foreign('rede_id')->references('id')->on('redes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipamentos');
    }
}
