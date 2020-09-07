<?php

date_default_timezone_set('America/Guatemala');
header('Access-Control-Allow-Headers:Origin, Content-Type, X-XSRF-TOKEN, Authorization');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
//header('Access-Control-Allow-Headers: Authorization,Content-Type');

	/*if("OPTIONS" == $_SERVER['REQUEST_METHOD']) {
	    http_response_code(200);
	    exit(0);
	}*/

Route::get('login',['as' => 'login', 'uses' => 'AuthController@mostrarLogin']);
Route::post('login',['as' => 'login', 'uses' => 'AuthController@login']);
Route::get('/', ['as' => 'inicio', 'uses' => 'AuthController@mostrarDashboard']);

Route::get('info', ['as' => 'info', 'uses' => 'AuthController@info']);

Route::group(['middleware' => 'auth'], function(){

	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'AuthController@mostrarDashboard']);

	Route::get('Anuncio/listado', ['as' => 'anuncios', 'uses' => 'AnuncioController@listado']);
	Route::get('Anuncio/agregar', ['as' => 'agregar_anuncio', 'uses' => 'AnuncioController@mostrarAgregar']);
	Route::post('Anuncio/agregar', ['as' => 'agregar_anuncio', 'uses' => 'AnuncioController@agregar']);
	Route::get('Anuncio/editar/{anuncio}', ['as' => 'editar_anuncio', 'uses' => 'AnuncioController@mostrarEditar']);
	Route::post('Anuncio/editar/{anuncio}', ['as' => 'editar_anuncio', 'uses' => 'AnuncioController@editar']);

	Route::get('Configuracion/listado', ['as' => 'configuraciones', 'uses' => 'ConfiguracionController@listado']);
	Route::get('Configuracion/agregar', ['as' => 'agregar_configuracion', 'uses' => 'ConfiguracionController@mostrarAgregar']);
	Route::post('Configuracion/agregar', ['as' => 'agregar_configuracion', 'uses' => 'ConfiguracionController@agregar']);
	Route::get('Configuracion/editar/{id}', ['as' => 'editar_configuracion', 'uses' => 'ConfiguracionController@mostrarEditar']);
	Route::post('Configuracion/editar/{id}', ['as' => 'editar_configuracion', 'uses' => 'ConfiguracionController@editar']);

	Route::get('Departamento/listado', ['as' => 'departamentos', 'uses' => 'DepartamentoController@listado']);
	Route::get('Departamento/agregar', ['as' => 'agregar_departamento', 'uses' => 'DepartamentoController@mostrarAgregar']);
	Route::post('Departamento/agregar', ['as' => 'agregar_departamento', 'uses' => 'DepartamentoController@agregar']);
	Route::get('Departamento/editar/{id}', ['as' => 'editar_departamento', 'uses' => 'DepartamentoController@mostrarEditar']);
	Route::post('Departamento/editar/{id}', ['as' => 'editar_departamento', 'uses' => 'DepartamentoController@editar']);

	Route::get('Estadio/listado', ['as' => 'estadios', 'uses' => 'EstadioController@listado']);
	Route::get('Estadio/agregar', ['as' => 'agregar_estadio', 'uses' => 'EstadioController@mostrarAgregar']);
	Route::post('Estadio/agregar', ['as' => 'agregar_estadio', 'uses' => 'EstadioController@agregar']);
	Route::get('Estadio/editar/{id}', ['as' => 'editar_estadio', 'uses' => 'EstadioController@mostrarEditar']);
	Route::post('Estadio/editar/{id}', ['as' => 'editar_estadio', 'uses' => 'EstadioController@editar']);

	Route::get('Equipo/listado', ['as' => 'equipos', 'uses' => 'EquipoController@listado']);
	Route::get('Equipo/agregar', ['as' => 'agregar_equipo', 'uses' => 'EquipoController@mostrarAgregar']);
	Route::post('Equipo/agregar', ['as' => 'agregar_equipo', 'uses' => 'EquipoController@agregar']);
	Route::get('Equipo/editar/{id}', ['as' => 'editar_equipo', 'uses' => 'EquipoController@mostrarEditar']);
	Route::post('Equipo/editar/{id}', ['as' => 'editar_equipo', 'uses' => 'EquipoController@editar']);

	Route::get('Evento/listado', ['as' => 'eventos', 'uses' => 'EventoController@listado']);
	Route::get('Evento/editar/{evento}', ['as' => 'editar_evento', 'uses' => 'EventoController@mostrarEditar']);
	Route::post('Evento/editar/{evento}', ['as' => 'editar_evento', 'uses' => 'EventoController@editar']);

	Route::get('Liga/listado', ['as' => 'ligas', 'uses' => 'LigaController@listado']);
	Route::get('Liga/agregar', ['as' => 'agregar_liga', 'uses' => 'LigaController@mostrarAgregar']);
	Route::post('Liga/agregar', ['as' => 'agregar_liga', 'uses' => 'LigaController@agregar']);
	Route::get('Liga/editar/{id}', ['as' => 'editar_liga', 'uses' => 'LigaController@mostrarEditar']);
	Route::post('Liga/editar/{id}', ['as' => 'editar_liga', 'uses' => 'LigaController@editar']);

	Route::get('Modulo/listado', ['as' => 'modulos', 'uses' => 'ModuloController@listado']);
	Route::get('Modulo/agregar', ['as' => 'agregar_modulo', 'uses' => 'ModuloController@mostrarAgregar']);
	Route::post('Modulo/agregar', ['as' => 'agregar_modulo', 'uses' => 'ModuloController@agregar']);
	Route::get('Modulo/editar/{id}', ['as' => 'editar_modulo', 'uses' => 'ModuloController@mostrarEditar']);
    Route::post('Modulo/editar/{id}', ['as' => 'editar_modulo', 'uses' => 'ModuloController@editar']);
    
    /* NOTIFICACIONES */
    Route::group(['prefix' => 'Notificacion'], function () {
        Route::get('listado','NotificacionController@listado')->name('notificaciones');
        Route::get('agregar-articulo','NotificacionController@mostrarAgregarArticulo')->name('agregar_notificacion_articulo');
        Route::post('agregar-articulo','NotificacionController@agregarArticulo')->name('agregar_notificacion_articulo');
        Route::get('agregar-tabla-posiciones/{liga}','NotificacionController@mostrarAgregarTablaPosiciones')->name('agregar_notificacion_tabla_posiciones');
        Route::post('agregar-tabla-posiciones/{liga}','NotificacionController@agregarTablaPosiciones')->name('agregar_notificacion_tabla_posiciones');
        Route::get('agregar-calendario/{liga}','NotificacionController@mostrarAgregarCalendario')->name('agregar_notificacion_calendario');
        Route::post('agregar-calendario/{liga}','NotificacionController@agregarCalendario')->name('agregar_notificacion_calendario');
    });

	Route::get('Tabla-Acumulada/listado/{ligaId}', ['as' => 'tablas_acumuladas', 'uses' => 'TablaAcumuladaController@listado']);
	Route::get('Tabla-Acumulada/agregar/{ligaId}', ['as' => 'agregar_tabla_acumulada', 'uses' => 'TablaAcumuladaController@mostrarAgregar']);
	Route::post('Tabla-Acumulada/agregar/{ligaId}', ['as' => 'agregar_tabla_acumulada', 'uses' => 'TablaAcumuladaController@agregar']);
	Route::get('Tabla-Acumulada/editar/{id}', ['as' => 'editar_tabla_acumulada', 'uses' => 'TablaAcumuladaController@mostrarEditar']);
	Route::post('Tabla-Acumulada/editar/{id}', ['as' => 'editar_tabla_acumulada', 'uses' => 'TablaAcumuladaController@editar']);

	Route::get('Descuento-Puntos/listado/{liga}', ['as' => 'descuento_puntos', 'uses' => 'DescuentoPuntosController@listado']);
	Route::get('Descuento-Puntos/agregar/{liga}/{campeonatoId}', ['as' => 'agregar_descuento_puntos', 'uses' => 'DescuentoPuntosController@mostrarAgregar']);
	Route::post('Descuento-Puntos/agregar/{liga}/{campeonatoId}', ['as' => 'agregar_descuento_puntos', 'uses' => 'DescuentoPuntosController@agregar']);
	Route::get('Descuento-Puntos/editar/{descuento_puntos}', ['as' => 'editar_descuento_puntos', 'uses' => 'DescuentoPuntosController@mostrarEditar']);
	Route::post('Descuento-Puntos/editar/{descuento_puntos}', ['as' => 'editar_descuento_puntos', 'uses' => 'DescuentoPuntosController@editar']);

	Route::get('Perfil/listado', ['as' => 'perfiles', 'uses' => 'PerfilController@listado']);
	Route::get('Perfil/agregar', ['as' => 'agregar_perfil', 'uses' => 'PerfilController@mostrarAgregar']);
	Route::post('Perfil/agregar', ['as' => 'agregar_perfil', 'uses' => 'PerfilController@agregar']);
	Route::get('Perfil/editar/{id}', ['as' => 'editar_perfil', 'uses' => 'PerfilController@mostrarEditar']);
	Route::post('Perfil/editar/{id}', ['as' => 'editar_perfil', 'uses' => 'PerfilController@editar']);
	Route::get('Perfil/permisos/{id}', ['as' => 'permisos', 'uses' => 'PermisoController@permisos']);
	Route::post('Perfil/permisos/{id}', ['as' => 'permisos', 'uses' => 'PermisoController@editar']);

	Route::get('Persona/listado', ['as' => 'personas', 'uses' => 'PersonaController@listado']);
	Route::get('Persona/agregar', ['as' => 'agregar_persona', 'uses' => 'PersonaController@mostrarAgregar']);
	Route::post('Persona/agregar', ['as' => 'agregar_persona', 'uses' => 'PersonaController@agregar']);
	Route::get('Persona/editar/{id}', ['as' => 'editar_persona', 'uses' => 'PersonaController@mostrarEditar']);
	Route::post('Persona/editar/{id}', ['as' => 'editar_persona', 'uses' => 'PersonaController@editar']);
	Route::get('Persona/reporte/', ['as' => 'reporte_personas', 'uses' => 'PersonaController@mostrarReporte']);
	Route::post('Persona/reporte/', ['as' => 'reporte_personas', 'uses' => 'PersonaController@reporte']);

	Route::get('Partido/listado/{campeonatoId}', ['as' => 'partidos_campeonato', 'uses' => 'PartidoController@listado']);
	Route::get('Partido/agregar/{campeonatoId}', ['as' => 'agregar_partido_campeonato', 'uses' => 'PartidoController@mostrarAgregar']);
	Route::post('Partido/agregar/{campeonatoId}', ['as' => 'agregar_partido_campeonato', 'uses' => 'PartidoController@agregar']);
	Route::get('Partido/editar/{id}', ['as' => 'editar_partido_campeonato', 'uses' => 'PartidoController@mostrarEditar']);
	Route::post('Partido/editar/{id}', ['as' => 'editar_partido_campeonato', 'uses' => 'PartidoController@editar']);
	Route::delete('Partido/eliminar', ['as' => 'eliminar_partido_campeonato', 'uses' => 'PartidoController@eliminar']);

	Route::get('Partido/agregar-jornada/{campeonatoId}/{numeroPartidos}', ['as' => 'agregar_jornada_campeonato', 'uses' => 'PartidoController@mostrarAgregarJornada']);
	Route::post('Partido/agregar-jornada/{campeonatoId}/{numeroPartidos}', ['as' => 'agregar_jornada_campeonato', 'uses' => 'PartidoController@agregarJornada']);

	Route::get('Partido/editar-jornada/{campeonatoId}/{jornadaId}', ['as' => 'editar_jornada_campeonato', 'uses' => 'PartidoController@mostrarEditarJornada']);
	Route::post('Partido/editar-jornada/{campeonatoId}/{jornadaId}', ['as' => 'editar_jornada_campeonato', 'uses' => 'PartidoController@editarJornada']);
	Route::get('Monitorear-Partido/{partidoId}', ['as' => 'monitorear', 'uses' => 'PartidoController@monitorear']);
	Route::get('Eventos-Partido/{partidoId}', ['as' => 'eventos_partido', 'uses' => 'EventoPartidoController@listado']);
	Route::get('Agregar-Evento/{partidoId}/{eventoId}/{equipoId}', ['as' => 'agregar_evento_partido', 'uses' => 'EventoPartidoController@mostrarAgregar']);
	Route::get('Agregar-Evento-Persona/{partidoId}/{eventoId}/{equipoId}', ['as' => 'agregar_evento_persona', 'uses' => 'EventoPartidoController@mostrarAgregarPersona']);
	Route::post('Agregar-Evento/{partidoId}/{eventoId}/{equipoId}', ['as' => 'agregar_evento_partido', 'uses' => 'EventoPartidoController@agregar']);
	Route::post('Agregar-Evento-Persona/{partidoId}/{eventoId}/{equipoId}', ['as' => 'agregar_evento_persona', 'uses' => 'EventoPartidoController@agregarPersona']);
	Route::get('Editar-Evento/{eventoId}/', ['as' => 'editar_evento_partido', 'uses' => 'EventoPartidoController@mostrarEditar']);
	Route::get('Editar-Evento-Persona/{eventoId}', ['as' => 'editar_evento_persona', 'uses' => 'EventoPartidoController@mostrarEditarPersona']);
	Route::post('Editar-Evento/{eventoId}', ['as' => 'editar_evento_partido', 'uses' => 'EventoPartidoController@editar']);
	Route::post('Editar-Evento-Persona/{eventoId}/', ['as' => 'editar_evento_persona', 'uses' => 'EventoPartidoController@editarPersona']);
	Route::get('Editar-Alineacion/{partidoId}/{eventoId}/{equipoId}', ['as' => 'editar_alineacion', 'uses' => 'AlineacionController@mostrarAlineacion']);
	Route::post('Editar-Alineacion/{partidoId}/{eventoId}/{equipoId}', ['as' => 'editar_alineacion', 'uses' => 'AlineacionController@alineacion']);
	Route::delete('Eliminar-Evento/{eventoId}', ['as' => 'eliminar_evento', 'uses' => 'EventoPartidoController@eliminarEvento']);

	Route::get('Editar-Minutos-Jugados/{partidoId}/{equipoId}', ['as' => 'editar_minutos_jugados', 'uses' => 'AlineacionController@mostrarEditarMinutos']);
	Route::post('Editar-Minutos-Jugados/{partidoId}/{equipoId}', ['as' => 'editar_minutos_jugados', 'uses' => 'AlineacionController@editarMinutos']);

	Route::get('Modificar-Partido/{partidoId}', ['as' => 'modificar_partido', 'uses' => 'EventoPartidoController@mostrarModificarPartido']);
	Route::post('Modificar-Partido/{partidoId}', ['as' => 'modificar_partido', 'uses' => 'EventoPartidoController@modificarPartido']);

	Route::get('Pais/listado', ['as' => 'paises', 'uses' => 'PaisController@listado']);
	Route::get('Pais/agregar', ['as' => 'agregar_pais', 'uses' => 'PaisController@mostrarAgregar']);
	Route::post('Pais/agregar', ['as' => 'agregar_pais', 'uses' => 'PaisController@agregar']);
	Route::get('Pais/editar/{id}', ['as' => 'editar_pais', 'uses' => 'PaisController@mostrarEditar']);
	Route::post('Pais/editar/{id}', ['as' => 'editar_pais', 'uses' => 'PaisController@editar']);

	Route::get('Campeonato/listado/{ligaId}', ['as' => 'campeonatos', 'uses' => 'CampeonatoController@listado']);
	Route::get('Campeonato/agregar/{ligaId}', ['as' => 'agregar_campeonato', 'uses' => 'CampeonatoController@mostrarAgregar']);
	Route::post('Campeonato/agregar/{ligaId}', ['as' => 'agregar_campeonato', 'uses' => 'CampeonatoController@agregar']);
	Route::get('Campeonato/editar/{id}', ['as' => 'editar_campeonato', 'uses' => 'CampeonatoController@mostrarEditar']);
	Route::post('Campeonato/editar/{id}', ['as' => 'editar_campeonato', 'uses' => 'CampeonatoController@editar']);

	Route::get('CampeonatoEquipo/agregar/{id}', ['as' => 'agregar_equipo_campeonato', 'uses' => 'CampeonatoEquipoController@mostrarAgregar']);
	Route::post('CampeonatoEquipo/agregar/{id}', ['as' => 'agregar_equipo_campeonato', 'uses' => 'CampeonatoEquipoController@agregar']);
	Route::get('CampeonatoEquipo/editar/{id}', ['as' => 'editar_equipos_campeonato', 'uses' => 'CampeonatoEquipoController@mostrarEditar']);
	Route::post('CampeonatoEquipo/editar/{id}', ['as' => 'editar_equipos_campeonato', 'uses' => 'CampeonatoEquipoController@editar']);
	Route::get('CampeonatoEquipo/trasladar-equipos/{campeonatoNuevo}/{campeonatoAntiguo}', ['as' => 'trasladar_equipos_campeonato',
			'uses' => 'CampeonatoEquipoController@mostrarTrasladarEquipos']);
	Route::post('CampeonatoEquipo/trasladar-equipos/{campeonatoNuevo}/{campeonatoAntiguo}', ['as' => 'trasladar_equipos_campeonato',
			'uses' => 'CampeonatoEquipoController@trasladarEquipos']);


	Route::get('EquipoPersona/agregar/{campeonatoEquipoId}/', ['as' => 'agregar_personas_equipo', 'uses' => 'PlantillaController@mostrarAgregar']);
	Route::post('EquipoPersona/agregar/{campeonatoEquipoId}/', ['as' => 'agregar_personas_equipo', 'uses' => 'PlantillaController@agregar']);
	Route::get('EquipoPersona/editar/{campeonatoEquipoId}', ['as' => 'editar_personas_equipo', 'uses' => 'PlantillaController@mostrarEditar']);
	Route::post('EquipoPersona/editar/{campeonatoEquipoId}', ['as' => 'editar_personas_equipo', 'uses' => 'PlantillaController@editar']);

	Route::get('Administracion/dashboard', ['as' => 'administracion', 'uses' => 'AuthController@mostrarAdminDashboard']);
	Route::get('monitorear-jornada/{ligaId}/{campeonatoId}/{jornadaId}/{partidoId}/{equipoId}', ['as' => 'monitorear_jornada', 'uses' => 'PartidoController@mostrarMonitorearJornada']);

	Route::get('Usuario/listado', ['as' => 'usuarios', 'uses' => 'UsuarioController@listado']);
	Route::get('Usuario/agregar', ['as' => 'agregar_usuario', 'uses' => 'UsuarioController@mostrarAgregar']);
	Route::post('Usuario/agregar', ['as' => 'agregar_usuario', 'uses' => 'UsuarioController@agregar']);
	Route::get('Usuario/editar/{id}', ['as' => 'editar_usuario', 'uses' => 'UsuarioController@mostrarEditar']);
	Route::post('Usuario/editar/{id}', ['as' => 'editar_usuario', 'uses' => 'UsuarioController@editar']);

	Route::get('HistorialCampeon/listado', ['as' => 'historial_campeones', 'uses' => 'HistorialCampeonController@listado']);
	Route::get('HistorialCampeon/agregar', ['as' => 'agregar_historial_campeon', 'uses' => 'HistorialCampeonController@mostrarAgregar']);
	Route::post('HistorialCampeon/agregar', ['as' => 'agregar_historial_campeon', 'uses' => 'HistorialCampeonController@agregar']);
	Route::get('HistorialCampeon/editar/{id}', ['as' => 'editar_historial_campeon', 'uses' => 'HistorialCampeonController@mostrarEditar']);
	Route::post('HistorialCampeon/editar/{id}', ['as' => 'editar_historial_campeon', 'uses' => 'HistorialCampeonController@editar']);

        //NOTIFICACIONES
    Route::get('UsersApp/listado', ['as' => 'users_app', 'uses' => 'UserAppController@listado']);
    Route::get('NotificacionEquipo/listado/{user_app}', ['as' => 'notificaciones_equipo', 'uses' => 'NotificacionEquipoController@listado']);

	/*ESTADISTICAS ADMINISTRATIVAS*/
	Route::get('Estadisticas/Jugadores/{ligaId}/{campeonato}', ['as' => 'estadisticas_jugadores', 'uses' => 'EstadisticasJugadoresController@mostrarEstadisticasJugadores']);
	Route::get('Estadisticas/PartidosXEquipo/{ligaId}/{equipo1Id}/{equipo2Id}', ['as' => 'partidos_equipos', 'uses' => 'AdminController@mostrarPartidoPorEquipo']);
	Route::get('Estadisticas/PartidosXJugador/{ligaId}/{jugadorId}/{equipoId}/{rivalId}/{campeonatoId}', ['as' => 'partidos_jugadores', 'uses' => 'AdminController@mostrarPartidoPorJugador']);
	Route::get('Estadisticas/PartidosXArbitro/{ligaId}/{arbitroId}/{equipoId}/{campeonatoId}', ['as' => 'partidos_arbitros', 'uses' => 'AdminController@mostrarPartidoPorArbitro']);
	Route::get('Estadisticas/Historia-Posiciones/{liga}', ['as' => 'posiciones_liga', 'uses' => 'AdminController@mostrarPosicionesLiga']);


	/*ESTADISTICAS ARBITROS*/
	Route::get('Estadisticas-Arbitros/dashboard/{ligaId}', ['as' => 'dashboard_admin_estadisticas_arbitros', 'uses' => 'EstadisticasArbitroController@dashboard']);
	Route::get('Estadisticas-Arbitros/{ligaId}/{campeonatoId}/{arbitroId}', ['as' => 'estadistica_arbitro_campeonato', 'uses' => 'EstadisticasArbitroController@partidoPorCampeonato']);


	Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

});



Route::get('posiciones/{ligaId}/{campeonatoId}', ['as' => 'posiciones', 'uses' => 'PublicController@posiciones']);
Route::get('posiciones-local/{ligaId}/{campeonatoId}', ['as' => 'posiciones_local', 'uses' => 'PublicController@posicionesLocal']);
Route::get('posiciones-visita/{ligaId}/{campeonatoId}', ['as' => 'posiciones_visita', 'uses' => 'PublicController@posicionesVisita']);
Route::get('tabla-acumulada/{ligaId}/{campeonatoId}', ['as' => 'tabla_acumulada', 'uses' => 'PublicController@tablaAcumulada']);

Route::get('goleadores/{ligaId}/{campeonatoId}', ['as' => 'goleadores', 'uses' => 'PublicController@goleadores']);
Route::get('porteros/{ligaId}/{campeonatoId}', ['as' => 'porteros', 'uses' => 'PublicController@porteros']);
Route::get('campeones/{ligaId}/{campeonatoId}', ['as' => 'campeones', 'uses' => 'PublicController@campeones']);

Route::get('dashboard/{ligaId}/{campeonatoId}', ['as' => 'calendario', 'uses' => 'PublicController@dashboard']);
Route::get('plantilla/{ligaId}/{campeonatoId}/{equipoId}', ['as' => 'plantilla', 'uses' => 'PublicController@plantilla']);
Route::get('calendario/{ligaId}/{campeonatoId}/{completo}', ['as' => 'calendario', 'uses' => 'PublicController@calendario']);
Route::get('calendario-equipo/{ligaId}/{campeonatoId}/{equipoId}', ['as' => 'calendario_equipo', 'uses' => 'PublicController@calendarioEquipo']);
Route::get('ficha/{partidoId}', ['as' => 'ficha', 'uses' => 'PublicController@ficha']);
Route::get('en-vivo/{partidoId}', ['as' => 'en_vivo', 'uses' => 'PublicController@enVivo']);
Route::get('previa/{partidoId}', ['as' => 'previa', 'uses' => 'PublicController@previa']);
Route::get('alineaciones/{partidoId}', ['as' => 'alineaciones', 'uses' => 'PublicController@alineaciones']);
Route::get('narracion/{partidoId}', ['as' => 'narracion', 'uses' => 'PublicController@narracion']);
Route::get('imagen-jornada/{ligaId}/{campeonatoId}/{jornadaId}/{tipo}', ['as' => 'imagen_jornada', 'uses' => 'PublicController@imagenJornada']);

Route::get('mini-posiciones/{ligaId}/{campeonatoId}', ['as' => 'mini_posiciones', 'uses' => 'PublicController@miniPosiciones']);
Route::get('mini-calendario/{ligaId}/{campeonatoId}/{completo}', ['as' => 'mini_calendario', 'uses' => 'PublicController@miniCalendario']);
Route::get('partidos-scroll', ['as' => 'partidos_scroll', 'uses' => 'PublicController@partidosScroll']);


Route::get('json-mini-posiciones/{ligaId}/{campeonatoId}', ['as' => 'json_mini_posiciones', 'uses' => 'PublicController@jsonMiniPosiciones']);
Route::get('json-mini-calendario/{ligaId}/{campeonatoId}/{completo}', ['as' => 'json_mini_calendario', 'uses' => 'PublicController@jsonMiniCalendario']);




/*REST ESTADISTICAS ADMIN */
Route::get('Jugadores-Liga/{ligaId}', ['as' => 'json_jugadores_liga', 'uses' => 'AdminController@jugadoresLiga']);
Route::get('Arbitros-Liga/{ligaId}', ['as' => 'json_arbitros_liga', 'uses' => 'AdminController@arbitrosLiga']);

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


// Redirect to github to authenticate
Route::post('facebook', 'FacebookController@facebook_redirect')->name('login_facebook');
// Get back to redirect url
Route::get('account/facebook', 'FacebookController@facebook');

// Redirect to github to authenticate
Route::get('twitter', 'TwitterController@twitter_redirect');
// Get back to redirect url
Route::get('account/twitter', 'TwitterController@twitter');



/*APP ANTIGUA*/
Route::get('app-antigua/rest/inicio/{ligaId}', ['uses' => 'AppAntiguaController@inicio']);
Route::get('app-antigua/rest/posiciones/{campeonatoid}', ['uses' => 'AppAntiguaController@posiciones']);
Route::get('app-antigua/rest/acumulada/{campeonatoid}', ['uses' => 'AppAntiguaController@acumulada']);
Route::get('app-antigua/rest/tabla-acumulada/{campeonatoid}', ['uses' => 'AppAntiguaController@acumulada']);
Route::get('app-antigua/rest/goleadores/{campeonatoid}', ['uses' => 'AppAntiguaController@goleadores']);
Route::get('app-antigua/rest/porteros/{campeonatoid}', ['uses' => 'AppAntiguaController@porteros']);
Route::get('app-antigua/rest/calendario/{campeonatoid}/{completo}', ['uses' => 'AppAntiguaController@calendario']);
Route::get('app-antigua/rest/eventos/{partidoId}', ['uses' => 'AppAntiguaController@eventos']);
Route::get('app-antigua/rest/en-vivo/{partidoId}', ['uses' => 'AppAntiguaController@enVivo']);
Route::get('app-antigua/rest/alineaciones/{partidoId}', ['uses' => 'AppAntiguaController@alineaciones']);
Route::get('app-antigua/rest/estadisticas/{partidoId} ', [ 'as' => 'estadisticas', 'uses' => 'AppAntiguaController@estadisticas']);

Route::get('app-antigua/rest/equipos/{campeonatoId}', ['uses' => 'AppAntiguaController@equipos']);
Route::get('app-antigua/rest/plantilla/{campeonatoId}/{equipoId}', ['uses' => 'AppAntiguaController@plantilla']);


/*FALTAN*/

Route::get('campeonato/{id}', [ 'as' => 'campeonato', 'uses' => 'RestController@campeonato']);

