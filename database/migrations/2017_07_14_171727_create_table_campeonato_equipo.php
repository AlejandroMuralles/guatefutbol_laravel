<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCampeonatoEquipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campeonato_equipo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campeonato_id')->unsigned();
            $table->integer('equipo_id')->unsigned();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('campeonato_id')->references('id')->on('campeonato');
            $table->foreign('equipo_id')->references('id')->on('equipo');
            $table->unique(['campeonato_id','equipo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campeonato_equipo');
    }
}
