<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRedesIdToEquipamentosTable extends Migration
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
            $table->integer('rede_id')->unsigned()->nullable();
            $table->foreign('rede_id')->references('id')->on('redes')->onDelete('set null');
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
            $table->dropForeign('equipamentos_rede_id_foreign');
            $table->dropColumn('rede_id');
        });
    }
}
