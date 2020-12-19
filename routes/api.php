<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v2'], function () {

    Route::get('partidos-agrupados-campeonato','ApiV2Controller@partidosAgrupadosPorCampeonato');
    Route::get('campeonato/{ligaId}/{campeonatoId}','ApiV2Controller@campeonato');
    Route::get('campeonatos','ApiV2Controller@campeonatos');

    Route::get('posiciones/{liga}/{campeonatoId}','ApiV2Controller@posiciones');
    Route::get('acumulada/{liga}/{campeonatoId}','ApiV2Controller@acumulada');
    Route::get('goleadores/{liga}/{campeonatoId}','ApiV2Controller@goleadores');
    Route::get('amarillas/{liga}/{campeonatoId}','ApiV2Controller@amarillas');
    Route::get('rojas/{liga}/{campeonatoId}','ApiV2Controller@rojas');
    Route::get('porteros/{liga}/{campeonatoId}','ApiV2Controller@porteros');
    Route::get('calendario/{liga}/{campeonatoId}/{completo}','ApiV2Controller@calendario');

    Route::get('jornadas/{liga}/{campeonatoId}','ApiV2Controller@jornadas');
    Route::get('partidos-por-jornada/{liga}/{campeonatoId}/{jornada}','ApiV2Controller@partidosByJornada');

    Route::get('partido/{id}','ApiV2Controller@partido');
    Route::get('narracion/{partido}','ApiV2Controller@narracion');
    Route::get('alineaciones/{partido}','ApiV2Controller@alineaciones');
    Route::get('eventos/{partido}','ApiV2Controller@eventos');

    Route::get('equipos/{ligaId}/{campeonatoId}','ApiV2Controller@equipos');
    Route::get('plantilla/{ligaId}/{campeonatoId}/{equipo}','ApiV2Controller@plantilla');
    Route::get('resumen/{ligaId}/{campeonatoId}/{equipo}','ApiV2Controller@resumen');

});
