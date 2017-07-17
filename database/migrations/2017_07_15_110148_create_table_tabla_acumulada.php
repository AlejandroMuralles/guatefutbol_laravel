<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTablaAcumulada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabla_acumulada', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campeonato1_id')->unsigned();
            $table->integer('campeonato2_id')->unsigned();
            $table->string('estado');
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('campeonato1_id')->references('id')->on('campeonato');
            $table->foreign('campeonato2_id')->references('id')->on('campeonato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabla_acumulada');
    }
}
