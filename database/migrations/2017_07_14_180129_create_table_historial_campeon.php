<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHistorialCampeon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_campeon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('campeonato');
            $table->string('equipo_campeon');
            $table->string('entrenador_campeon');
            $table->string('equipo_subcampeon');
            $table->date('fecha');
            $table->integer('veces_equipo');
            $table->integer('veces_entrenador');
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_campeon');
    }
}
