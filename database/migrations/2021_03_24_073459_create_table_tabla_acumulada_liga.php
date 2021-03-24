<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTablaAcumuladaLiga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabla_acumulada_liga', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->integer('liga_id')->unsigned();
            $table->string('estado');
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('liga_id')->references('id')->on('liga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabla_acumulada_liga');
    }
}
