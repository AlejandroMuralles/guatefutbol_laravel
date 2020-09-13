<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v2'], function () {

    Route::get('posiciones/{liga}/{campeonatoId}','ApiV2Controller@posiciones');
    Route::get('goleadores/{liga}/{campeonatoId}','ApiV2Controller@goleadores');
    Route::get('porteros/{liga}/{campeonatoId}','ApiV2Controller@porteros');

});
