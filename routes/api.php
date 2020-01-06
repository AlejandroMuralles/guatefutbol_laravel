<?php

use Illuminate\Http\Request;

date_default_timezone_set('America/Guatemala');
header('Access-Control-Allow-Headers:Origin, Content-Type, X-XSRF-TOKEN, Authorization');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

/* REST APP*/
Route::get('rest/inicio-ligas-agrupadas', ['uses' => 'RestController@inicioLigasAgrupadas']);
Route::get('rest/inicio-ligas-agrupadas-v2', ['uses' => 'RestController@inicioLigasAgrupadasV2']);
Route::get('rest/inicio/', ['uses' => 'RestController@inicioLigas']);
Route::get('rest/inicio/{ligaId}', ['uses' => 'RestController@inicio']);
Route::get('rest/inicio/{ligaId}/{campeonatoId}', ['uses' => 'RestController@inicioConCampeonato']);
Route::get('rest/posiciones/{ligaId}/{campeonatoid}', ['uses' => 'RestController@posiciones']);
Route::get('rest/acumulada/{ligaId}/{campeonatoid}', ['uses' => 'RestController@acumulada']);
Route::get('rest/tabla-acumulada/{ligaId}/{campeonatoid}', ['uses' => 'RestController@acumulada']);
Route::get('rest/goleadores/{ligaId}/{campeonatoid}', ['uses' => 'RestController@goleadores']);
Route::get('rest/porteros/{ligaId}/{campeonatoid}', ['uses' => 'RestController@porteros']);
Route::get('rest/calendario/{ligaId}/{campeonatoid}/{completo}', ['uses' => 'RestController@calendario']);
Route::get('rest/eventos/{partidoId}', ['uses' => 'RestController@eventos']);
Route::get('rest/en-vivo/{partidoId}', ['uses' => 'RestController@enVivo']);
Route::get('rest/alineaciones/{partidoId}', ['uses' => 'RestController@alineaciones']);
Route::get('rest/wordpress-posts/{page}', ['uses' => 'RestController@wordpressPosts']);

Route::get('rest/equipos/{ligaId}/{campeonatoId}', ['uses' => 'RestController@equipos']);
Route::get('rest/plantilla/{ligaId}/{campeonatoId}/{equipoId}', ['uses' => 'RestController@plantilla']);
Route::get('rest/campeonatos-app', ['uses' => 'RestController@campeonatosApp']);
Route::get('rest/siguiente-anuncio/{id}', ['as' => 'siguiente_anuncio', 'uses' => 'AnuncioController@siguiente']);


Route::post('rest/add-user', ['as'=>'add_user', 'uses' => 'MobileController@addUser']);
Route::post('rest/remove-user', ['as'=>'remove_user', 'uses' => 'MobileController@removeUser']);

Route::get('rest/notificaciones/ligas', ['uses' => 'NotificacionesController@ligas']);
Route::get('rest/notificaciones/equipos/{user}/{ligaId}', ['uses' => 'NotificacionesController@equiposporUser']);
Route::post('rest/notificaciones/agregar-equipo-user', ['as'=>'agregar_notificacion_equipo_app', 'uses' => 'NotificacionesController@agregarEquipoUser']);
Route::post('rest/notificaciones/eliminar-equipo-user', ['as'=>'eliminar_notificacion_equipo_app', 'uses' => 'NotificacionesController@eliminarEquipoUser']);

Route::post('rest/users-app/registrar', ['uses' => 'UserAppController@registrar']);
Route::post('rest/users-app/activar-notificaciones', ['as' => 'activar_notificaciones_users_app', 'uses' => 'UserAppController@activarNotificaciones']);
Route::post('rest/users-app/desactivar-notificaciones', ['as' => 'desactivar_notificaciones_users_app', 'uses' => 'UserAppController@desactivarNotificaciones']);