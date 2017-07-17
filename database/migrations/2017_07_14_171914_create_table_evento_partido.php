<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEventoPartido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_partido', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('partido_id')->unsigned();
            $table->integer('evento_id')->unsigned();
            $table->integer('minuto');
            $table->tinyInteger('doble_amarilla')->nullable();
            $table->integer('jugador1_id')->unsigned()->nullable();
            $table->integer('jugador2_id')->unsigned()->nullable();
            $table->integer('equipo_id')->unsigned()->nullable();
            $table->string('comentario');
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('partido_id')->references('id')->on('partido');
            $table->foreign('evento_id')->references('id')->on('evento');
            $table->foreign('equipo_id')->references('id')->on('equipo');
            $table->foreign('jugador1_id')->references('id')->on('persona');
            $table->foreign('jugador2_id')->references('id')->on('persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_partido');
    }
}
