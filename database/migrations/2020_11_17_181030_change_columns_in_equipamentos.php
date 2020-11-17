<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInEquipamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            $table->dropColumn('naopatrimoniado');
            $table->renameColumn('descricaosempatrimonio', 'descricao');
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
