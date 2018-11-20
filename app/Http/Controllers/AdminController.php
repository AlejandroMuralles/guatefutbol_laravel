<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, View, Session, stdClass;

use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\PlantillaRepo;
use App\App\Repositories\EquipoRepo;
use App\App\Repositories\PartidoRepo;
use App\App\Repositories\PersonaRepo;
use App\App\Repositories\AlineacionRepo;
use App\App\Repositories\EventoPartidoRepo;
use App\App\Repositories\PosicionesRepo;

use App\App\Entities\Equipo;
use App\App\Entities\Liga;

class AdminController extends BaseController {

	protected $equipoRepo;
	protected $partidoRepo;
	protected $personaRepo;
	protected $campeonatoEquipoRepo;
	protected $alineacionRepo;
	protected $eventoPartidoRepo;
	protected $posicionesRepo;

	public function __construct(EquipoRepo $equipoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, PlantillaRepo $plantillaRepo,
								PartidoRepo $partidoRepo, PersonaRepo $personaRepo, AlineacionRepo $alineacionRepo, EventoPartidoRepo $eventoPartidoRepo, PosicionesRepo $posicionesRepo)
	{
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->plantillaRepo = $plantillaRepo;
		$this->equipoRepo = $equipoRepo;
		$this->partidoRepo = $partidoRepo;
		$this->personaRepo = $personaRepo;
		$this->alineacionRepo = $alineacionRepo;
		$this->eventoPartidoRepo = $eventoPartidoRepo;
		$this->posicionesRepo = $posicionesRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarPartidoPorEquipo($ligaId, $equipo1Id, $equipo2Id)
	{
		$equipo1 = $this->equipoRepo->find($equipo1Id);
		$equipo2 = $this->equipoRepo->find($equipo2Id);
		$equipos = $this->campeonatoEquipoRepo->getByLiga($ligaId)->pluck('nombre','id')->toArray();

		if($equipo2Id == -1){
			$partidos = $this->partidoRepo->getByLigaByEquipo($ligaId, $equipo1Id);
		}
		else{
			$partidos = $this->partidoRepo->getBetweenEquipos($ligaId, $equipo1Id, $equipo2Id);
		}

		$estadisticas1 = new stdClass();
		$estadisticas1->equipo = $equipo1;
		$estadisticas1->JJ = 0; $estadisticas1->JG = 0; $estadisticas1->JE = 0; $estadisticas1->JP = 0; $estadisticas1->GF = 0; $estadisticas1->GC = 0;

		$estadisticas2 = new stdClass();
		if($equipo2Id == -1){
			$e = new Equipo();
			$e->nombre = 'Todos';
			$estadisticas2->equipo = $e;
		}
		else
			$estadisticas2->equipo = $equipo2;
		$estadisticas2->JJ = 0; $estadisticas2->JG = 0; $estadisticas2->JE = 0; $estadisticas2->JP = 0; $estadisticas2->GF = 0; $estadisticas2->GC = 0;

		foreach($partidos as $partido)
		{
			$estadisticas1->JJ++;
			$estadisticas2->JJ++;
			if($partido->equipo_local_id == $equipo1Id)
			{
				$estadisticas1->GF += $partido->goles_local;
				$estadisticas1->GC += $partido->goles_visita;
				$estadisticas2->GF += $partido->goles_visita;
				$estadisticas2->GC += $partido->goles_local;

				if($partido->goles_local > $partido->goles_visita)
				{
					$estadisticas1->JG++;
					$estadisticas2->JP++;
				}
				else if($partido->goles_local < $partido->goles_visita)
				{
					$estadisticas1->JP++;
					$estadisticas2->JG++;
				}
				else{
					$estadisticas1->JE++;
					$estadisticas2->JE++;
				}
			}
			else if($partido->equipo_visita_id == $equipo1Id)
			{
				$estadisticas2->GF += $partido->goles_local;
				$estadisticas2->GC += $partido->goles_visita;
				$estadisticas1->GF += $partido->goles_visita;
				$estadisticas1->GC += $partido->goles_local;

				if($partido->goles_local > $partido->goles_visita)
				{
					$estadisticas2->JG++;
					$estadisticas1->JP++;
				}
				else if($partido->goles_local < $partido->goles_visita)
				{
					$estadisticas2->JP++;
					$estadisticas1->JG++;
				}
				else{
					$estadisticas1->JE++;
					$estadisticas2->JE++;
				}

			}
		}

		return view('administracion/Estadisticas/partidos_equipos', compact('estadisticas1','estadisticas2','partidos','equipos','equipo1Id','equipo2Id','ligaId'));

	}

	public function mostrarPartidoPorJugador($ligaId, $jugadorId, $equipoId, $rivalId, $campeonatoId)
	{
		$jugador = $this->personaRepo->find($jugadorId);

		if($rivalId != 0){
			$alineaciones = $this->alineacionRepo->getPartidosByJugadorByRival($ligaId, $rivalId, $jugadorId);
		}
		else if($equipoId != 0){
			$alineaciones = $this->alineacionRepo->getPartidosByJugadorByEquipo($ligaId, $equipoId, $jugadorId);
		}
		else if($campeonatoId != 0)
		{
			$alineaciones = $this->alineacionRepo->getPartidosByJugadorByCampeonato($campeonatoId, $jugadorId);
		}
		else {
			$alineaciones = $this->alineacionRepo->getPartidosByJugadorByLiga($ligaId, $jugadorId);
		}

		$alineaciones = $alineaciones->sortBy(function ($alineacion, $key) {
		    return $alineacion->partido->fecha;
		});

		$ganados = 0;
	    $empatados = 0;
	    $perdidos = 0;
	    $apariciones = 0;
	    $goles = 0;
	    $amarillas = 0;
	    $doblesamarillas = 0;
	    $rojas = 0;
	    $minutosJugados = 0;
	    $totales = new stdClass();

	    $totalesEquipos = [];

	    foreach($alineaciones as $alineacion)
	    {
	    	$apariciones++;
	    	$alineacion->AP = $apariciones;
	    	$minutosJugados += $alineacion->minutos_jugados;
	    	$campeonato = $alineacion->partido->campeonato->nombre;
	    	$equipo = $alineacion->equipo->nombre;

	    	if(!isset($totalesEquipos[$alineacion->equipo_id])){
	    		$totalesEquipos[$alineacion->equipo_id] = new stdClass();
		    	$totalesEquipos[$alineacion->equipo_id]->equipo = "";
			    $totalesEquipos[$alineacion->equipo_id]->ganados = 0;
			    $totalesEquipos[$alineacion->equipo_id]->empatados = 0;
			    $totalesEquipos[$alineacion->equipo_id]->perdidos = 0;
			    $totalesEquipos[$alineacion->equipo_id]->goles = 0;
			    $totalesEquipos[$alineacion->equipo_id]->amarillas = 0;
			    $totalesEquipos[$alineacion->equipo_id]->doblesamarillas = 0;
			    $totalesEquipos[$alineacion->equipo_id]->rojas = 0;
			    $totalesEquipos[$alineacion->equipo_id]->apariciones = 0;
			    $totalesEquipos[$alineacion->equipo_id]->minutos_jugados = 0;
			}


	    	$totalesEquipos[$alineacion->equipo_id]->equipo = $alineacion->equipo;
	    	$totalesEquipos[$alineacion->equipo_id]->minutos_jugados+= $alineacion->minutos_jugados;
	    	$totalesEquipos[$alineacion->equipo_id]->apariciones++;

	    	if($alineacion->equipo_id == $alineacion->partido->equipo_local_id){
	    		$alineacion->rival = $alineacion->partido->equipo_visita;
	    		if($alineacion->partido->goles_local > $alineacion->partido->goles_visita){
	    			$totalesEquipos[$alineacion->equipo_id]->ganados++;
	    			$ganados++;
	    		}
	    		else if($alineacion->partido->goles_local < $alineacion->partido->goles_visita) {
	    			$totalesEquipos[$alineacion->equipo_id]->perdidos++;
	    			$perdidos++;
	    		}
	    		else {
	    			$totalesEquipos[$alineacion->equipo_id]->empatados++;
	    			$empatados++;
	    		}
	    	}
	    	else{
	    		$alineacion->rival = $alineacion->partido->equipo_local;
	    		if($alineacion->partido->goles_local > $alineacion->partido->goles_visita) {
	    			$totalesEquipos[$alineacion->equipo_id]->perdidos++;
	    			$perdidos++;
	    		}
	    		else if($alineacion->partido->goles_local < $alineacion->partido->goles_visita) {
	    			$totalesEquipos[$alineacion->equipo_id]->ganados++;
	    			$ganados++;
	    		}
	    		else {
	    			$totalesEquipos[$alineacion->equipo_id]->empatados++;
	    			$empatados++;
	    		}
	    	}

	    	$rival = $alineacion->rival->nombre;

	    	$eventos = $this->eventoPartidoRepo->getAllByEventoByPartidoByPersona([6,7,8,10,11], $alineacion->partido_id, $alineacion->persona_id);

	    	$alineacion->goles = 0;
	    	$alineacion->amarillas = 0;
	    	$alineacion->doblesamarillas = 0;
	    	$alineacion->rojas = 0;
	    	foreach($eventos as $evento)
	    	{
	    		if($evento->evento_id == 6 || $evento->evento_id == 8){
	    			$goles++;
	    			$alineacion->goles++;
	    			$totalesEquipos[$alineacion->equipo_id]->goles++;
	    		}
	    		if($evento->evento_id == 10){
	    			$amarillas++;
	    			$alineacion->amarillas++;
	    			$totalesEquipos[$alineacion->equipo_id]->amarillas++;
	    		}
	    		if($evento->evento_id == 11)
	    			if($evento->doble_amarilla == 1) {
	    				$doblesamarillas++;
	    				$alineacion->doblesamarillas++;
	    				$totalesEquipos[$alineacion->equipo_id]->doblesamarillas++;

	    				$alineacion->amarillas--;
						$totalesEquipos[$alineacion->equipo_id]->amarillas--;
						$amarillas--;
	    			}
	    			else{
	    				$rojas++;
	    				$alineacion->rojas++;
	    				$totalesEquipos[$alineacion->equipo_id]->rojas++;
	    			}
	    	}
	    	$alineacion->goles_acumulados = $goles;

	    }

	    $totales->ganados = $ganados;
	    $totales->perdidos = $perdidos;
	    $totales->empatados = $empatados;
	    $totales->apariciones = $apariciones;
	    $totales->goles = $goles;
	    $totales->amarillas = $amarillas;
	    $totales->doblesamarillas = $doblesamarillas;
	    $totales->rojas = $rojas;
	    $totales->minutos_jugados = $minutosJugados;


		return view('administracion/Estadisticas/partidos_jugadores',compact('ligaId','jugadorId','equipoId','rivalId','campeonatoId','jugador','partidos','alineaciones', 'totales','totalesEquipos','equipo','rival','campeonato'));
	}

	public function mostrarPartidosPorArbitroPorEquipo($ligaId, $arbitroId, $equipoId, $campeonatoId)
	{
		$jugador = $this->personaRepo->find($jugadorId);

		if($equipoId != 0){
			$partidos = $this->partidoRepo->getPartidosByArbitroByEquipo($ligaId, $equipoId, $arbitroId);
		}
		else if($campeonatoId != 0)
		{
			$partidos = $this->partidoRepo->getPartidosByArbitroByCampeonato($campeonatoId, $arbitroId);
		}
		else {
			$partidos = $this->partidoRepo->getPartidosByArbitroByLiga($ligaId, $arbitroId);
		}

		$partidos = $partidos->sortBy(function ($partido, $key) {
		    return $partido->fecha;
		});

		$ganados = 0;
	    $empatados = 0;
	    $perdidos = 0;
	    $apariciones = 0;
	    $goles = 0;
	    $amarillas = 0;
	    $doblesamarillas = 0;
	    $rojas = 0;
	    $minutosJugados = 0;
	    $totales = new stdClass();

	    $totalesEquipos = [];

	    foreach($alineaciones as $alineacion)
	    {
	    	$apariciones++;
	    	$alineacion->AP = $apariciones;
	    	$minutosJugados += $alineacion->minutos_jugados;
	    	$campeonato = $alineacion->partido->campeonato->nombre;
	    	$equipo = $alineacion->equipo->nombre;

	    	if(!isset($totalesEquipos[$alineacion->equipo_id])){
	    		$totalesEquipos[$alineacion->equipo_id] = new stdClass();
		    	$totalesEquipos[$alineacion->equipo_id]->equipo = "";
			    $totalesEquipos[$alineacion->equipo_id]->ganados = 0;
			    $totalesEquipos[$alineacion->equipo_id]->empatados = 0;
			    $totalesEquipos[$alineacion->equipo_id]->perdidos = 0;
			    $totalesEquipos[$alineacion->equipo_id]->goles = 0;
			    $totalesEquipos[$alineacion->equipo_id]->amarillas = 0;
			    $totalesEquipos[$alineacion->equipo_id]->doblesamarillas = 0;
			    $totalesEquipos[$alineacion->equipo_id]->rojas = 0;
			    $totalesEquipos[$alineacion->equipo_id]->apariciones = 0;
			    $totalesEquipos[$alineacion->equipo_id]->minutos_jugados = 0;
			}


	    	$totalesEquipos[$alineacion->equipo_id]->equipo = $alineacion->equipo;
	    	$totalesEquipos[$alineacion->equipo_id]->minutos_jugados+= $alineacion->minutos_jugados;
	    	$totalesEquipos[$alineacion->equipo_id]->apariciones++;

	    	if($alineacion->equipo_id == $alineacion->partido->equipo_local_id){
	    		$alineacion->rival = $alineacion->partido->equipoVisita;
	    		if($alineacion->partido->goles_local > $alineacion->partido->goles_visita){
	    			$totalesEquipos[$alineacion->equipo_id]->ganados++;
	    			$ganados++;
	    		}
	    		else if($alineacion->partido->goles_local < $alineacion->partido->goles_visita) {
	    			$totalesEquipos[$alineacion->equipo_id]->perdidos++;
	    			$perdidos++;
	    		}
	    		else {
	    			$totalesEquipos[$alineacion->equipo_id]->empatados++;
	    			$empatados++;
	    		}
	    	}
	    	else{
	    		$alineacion->rival = $alineacion->partido->equipoLocal;
	    		if($alineacion->partido->goles_local > $alineacion->partido->goles_visita) {
	    			$totalesEquipos[$alineacion->equipo_id]->perdidos++;
	    			$perdidos++;
	    		}
	    		else if($alineacion->partido->goles_local < $alineacion->partido->goles_visita) {
	    			$totalesEquipos[$alineacion->equipo_id]->ganados++;
	    			$ganados++;
	    		}
	    		else {
	    			$totalesEquipos[$alineacion->equipo_id]->empatados++;
	    			$empatados++;
	    		}
	    	}

	    	$rival = $alineacion->rival->nombre;

	    	$eventos = $this->eventoPartidoRepo->getAllByEventoByPartidoByPersona([6,7,8,10,11], $alineacion->partido_id, $alineacion->persona_id);

	    	$alineacion->goles = 0;
	    	$alineacion->amarillas = 0;
	    	$alineacion->doblesamarillas = 0;
	    	$alineacion->rojas = 0;
	    	foreach($eventos as $evento)
	    	{
	    		if($evento->evento_id == 6 || $evento->evento_id == 8){
	    			$goles++;
	    			$alineacion->goles++;
	    			$totalesEquipos[$alineacion->equipo_id]->goles++;
	    		}
	    		if($evento->evento_id == 10){
	    			$amarillas++;
	    			$alineacion->amarillas++;
	    			$totalesEquipos[$alineacion->equipo_id]->amarillas++;
	    		}
	    		if($evento->evento_id == 11)
	    			if($evento->doble_amarilla == 1) {
	    				$doblesamarillas++;
	    				$alineacion->doblesamarillas++;
	    				$totalesEquipos[$alineacion->equipo_id]->doblesamarillas++;

	    				$alineacion->amarillas--;
	    				$totalesEquipos[$alineacion->equipo_id]->amarillas--;
	    			}
	    			else{
	    				$rojas++;
	    				$alineacion->rojas++;
	    				$totalesEquipos[$alineacion->equipo_id]->rojas++;
	    			}
	    	}
	    	$alineacion->goles_acumulados = $goles;

	    }

	    $totales->ganados = $ganados;
	    $totales->perdidos = $perdidos;
	    $totales->empatados = $empatados;
	    $totales->apariciones = $apariciones;
	    $totales->goles = $goles;
	    $totales->amarillas = $amarillas;
	    $totales->doblesamarillas = $doblesamarillas;
	    $totales->rojas = $rojas;
	    $totales->minutos_jugados = $minutosJugados;


		return view('administracion/Estadisticas/partidos_jugadores',compact('ligaId','jugadorId','equipoId','rivalId','campeonatoId','jugador','partidos','alineaciones', 'totales','totalesEquipos','equipo','rival','campeonato'));
	}

	public function mostrarPosicionesLiga(Liga $liga)
	{
		$partidos = $this->partidoRepo->getByLigaByFaseByEstado($liga->id, ['R'], [2,3]);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosicionesByLiga($liga->id);
		$posiciones = $this->posicionesRepo->getTablaByLiga($liga->id, 0, $partidos, $equipos);
		return view('administracion/Estadisticas/posiciones_liga', compact('posiciones','liga'));
	}

	public function jugadoresLiga($ligaId)
	{
		$nombre = Input::get('term');
		$personas = $this->plantillaRepo->getAutocompletePersonas($ligaId, $nombre, ['J']);
		return json_encode($personas);
	}

	public function arbitrosLiga($ligaId)
	{
		$nombre = Input::get('term');
		$personas = $this->partidoRepo->getAutocompletePersonas($ligaId, $nombre, ['A']);
		return json_encode($personas->toArray());
	}

}
