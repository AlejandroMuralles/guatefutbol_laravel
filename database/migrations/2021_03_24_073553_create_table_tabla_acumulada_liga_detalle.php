<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTablaAcumuladaLigaDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabla_acumulada_liga_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tabla_acumulada_liga_id')->unsigned();
            $table->integer('campeonato_id')->unsigned()->unique();
            $table->string('estado');
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('tabla_acumulada_liga_id','fk_taliga_taligadet')->references('id')->on('tabla_acumulada_liga');
            $table->foreign('campeonato_id')->references('id')->on('campeonato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabla_acumulada_liga_detalle');
    }
}
