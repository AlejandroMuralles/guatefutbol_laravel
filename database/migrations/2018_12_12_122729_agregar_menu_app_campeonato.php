<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarMenuAppCampeonato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campeonato', function (Blueprint $table) {
            $table->tinyInteger('menu_app_calendario');
            $table->tinyInteger('menu_app_posiciones');
            $table->tinyInteger('menu_app_tala_acumulada');
            $table->tinyInteger('menu_app_goleadores');
            $table->tinyInteger('menu_app_porteros');
            $table->tinyInteger('menu_app_plantilla');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campeonato', function (Blueprint $table) {
            $table->dropColumn(['menu_app_calendario', 'menu_app_posiciones', 'menu_app_tala_acumulada',
                                'menu_app_goleadores','menu_app_porteros','menu_app_plantilla']);
        });
    }
}
