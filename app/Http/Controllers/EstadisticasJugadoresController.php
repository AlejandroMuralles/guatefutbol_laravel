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
use App\App\Repositories\VwEstadisticaJugadorLigaRepo;
use App\App\Repositories\VwEstadisticaJugadorCampeonatoRepo;
use App\App\Repositories\LigaRepo;
use App\App\Repositories\CampeonatoRepo;

use App\App\Entities\Equipo;
use App\App\Entities\Liga;

class EstadisticasJugadoresController extends BaseController {

	protected $equipoRepo;
	protected $partidoRepo;
	protected $personaRepo;
	protected $campeonatoEquipoRepo;
	protected $alineacionRepo;
	protected $eventoPartidoRepo;
	protected $posicionesRepo;
	protected $vwEstadisticaJugadorLigaRepo;
	protected $vwEstadisticaJugadorCampeonatoRepo;
	protected $ligaRepo;
	protected $campeonatoRepo;

	public function __construct(EquipoRepo $equipoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, PlantillaRepo $plantillaRepo,
								PartidoRepo $partidoRepo, PersonaRepo $personaRepo, AlineacionRepo $alineacionRepo, EventoPartidoRepo $eventoPartidoRepo, 
								PosicionesRepo $posicionesRepo,LigaRepo $ligaRepo, CampeonatoRepo $campeonatoRepo,
								VwEstadisticaJugadorLigaRepo $vwEstadisticaJugadorLigaRepo, 
								VwEstadisticaJugadorCampeonatoRepo $vwEstadisticaJugadorCampeonatoRepo
								)
	{
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->plantillaRepo = $plantillaRepo;
		$this->equipoRepo = $equipoRepo;
		$this->partidoRepo = $partidoRepo;
		$this->personaRepo = $personaRepo;
		$this->alineacionRepo = $alineacionRepo;
		$this->eventoPartidoRepo = $eventoPartidoRepo;
		$this->posicionesRepo = $posicionesRepo;
		$this->vwEstadisticaJugadorLigaRepo = $vwEstadisticaJugadorLigaRepo;
		$this->vwEstadisticaJugadorCampeonatoRepo = $vwEstadisticaJugadorCampeonatoRepo;
		$this->ligaRepo = $ligaRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarEstadisticasJugadores($ligaId, $campeonatoId)
	{
		$liga = $this->ligaRepo->find($ligaId);
		$campeonatos = $this->campeonatoRepo->getByLiga($ligaId)->pluck('nombre','id')->toArray();
		$campeonato = null;
		if($campeonatoId == 0)
		{
			$jugadores = $this->vwEstadisticaJugadorLigaRepo->getByLiga($ligaId);
		}
		else{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
			$jugadores = $this->vwEstadisticaJugadorCampeonatoRepo->getByCampeonato($campeonatoId);
		}
		return view('administracion/Estadisticas/jugadores_liga', compact('jugadores','ligaId','campeonatoId','liga','campeonatos','campeonato'));
	}
}

