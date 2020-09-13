<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v2'], function () {

    Route::get('posiciones/{liga}/{campeonatoId}','ApiV2Controller@posiciones');
    Route::get('acumulada/{liga}/{campeonatoId}','ApiV2Controller@acumulada');
    Route::get('goleadores/{liga}/{campeonatoId}','ApiV2Controller@goleadores');
    Route::get('porteros/{liga}/{campeonatoId}','ApiV2Controller@porteros');

});
