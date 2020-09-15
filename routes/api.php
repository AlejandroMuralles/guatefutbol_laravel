<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v2'], function () {

    Route::get('posiciones/{liga}/{campeonatoId}','ApiV2Controller@posiciones');
    Route::get('acumulada/{liga}/{campeonatoId}','ApiV2Controller@acumulada');
    Route::get('goleadores/{liga}/{campeonatoId}','ApiV2Controller@goleadores');
    Route::get('porteros/{liga}/{campeonatoId}','ApiV2Controller@porteros');
    Route::get('calendario/{liga}/{campeonatoId}/{completo}','ApiV2Controller@calendario');

    Route::get('jornadas/{liga}/{campeonatoId}','ApiV2Controller@jornadas');
    Route::get('partidos-por-jornada/{liga}/{campeonatoId}/{jornada}','ApiV2Controller@partidosByJornada');

    Route::get('narracion/{partido}','ApiV2Controller@narracion');

});
