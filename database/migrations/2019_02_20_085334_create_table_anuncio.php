<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAnuncio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anuncio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pantalla_app');
            $table->string('anunciante',2);
            $table->string('nombre_anunciante');
            $table->string('tipo',2);
            $table->integer('segundos_mostrandose');
            $table->integer('minutos_espera');
            $table->string('link')->nullable();
            $table->string('imagen')->nullable();
            $table->string('estado');
            $table->timestamps();
            $table->string('created_by');
            $table->string('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anuncio');
    }
}
