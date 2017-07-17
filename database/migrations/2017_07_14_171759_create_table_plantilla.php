<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlantilla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantilla', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campeonato_id')->unsigned();
            $table->integer('equipo_id')->unsigned();
            $table->integer('persona_id')->unsigned();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('campeonato_id')->references('id')->on('campeonato');
            $table->foreign('persona_id')->references('id')->on('persona');
            $table->foreign('equipo_id')->references('id')->on('equipo');
            $table->unique(['campeonato_id','persona_id','equipo_id'],'plantilla_uq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantilla');
    }
}
