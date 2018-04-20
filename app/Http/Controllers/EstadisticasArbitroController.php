<?php

namespace App\Http\Controllers;

use App\App\Repositories\PartidoRepo;
use App\App\Repositories\LigaRepo;
use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\EventoPartidoRepo;
use App\App\Repositories\PersonaRepo;
use Controller, Redirect, Input, View, Session;

class EstadisticasArbitroController extends BaseController {

	protected $ligaRepo;
	protected $campeonatoRepo;
	protected $partidoRepo;
	protected $personaRepo;
	protected $partidoEventoRepo;

	public function __construct(LigaRepo $ligaRepo, CampeonatoRepo $campeonatoRepo, PartidoRepo $partidoRepo, EventoPartidoRepo $eventoPartidoRepo, PersonaRepo $personaRepo)
	{
		$this->partidoRepo = $partidoRepo;
		$this->personaRepo = $personaRepo;
		$this->eventoPartidoRepo = $eventoPartidoRepo;
		$this->ligaRepo = $ligaRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function dashboard($ligaId)
	{
		return view('administracion/EstadisticasArbitros/dashboard',compact('ligaId'));
	}

	public function partidoPorCampeonato($ligaId, $campeonatoId, $arbitroId)
	{
		$arbitro = $this->personaRepo->find($arbitroId);
		$todos = array(0=>'Todos los campeonatos');
		$campeonatos = $this->campeonatoRepo->getByLiga($ligaId)->pluck('nombre','id')->toArray();
		$campeonatos = $todos + $campeonatos;
		if($campeonatoId != 0)
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
			$partidos = $this->partidoRepo->getByArbitroByCampeonato($arbitroId, $campeonatoId);
			$partidosIds = $this->partidoRepo->getIdsByArbitroByCampeonato($arbitroId, $campeonatoId);
			$eventos = $this->eventoPartidoRepo->getByEventosByPartidos($partidosIds, [6,10,11] );
		}
		else{
			$liga = $this->ligaRepo->find($ligaId);
			$partidos = $this->partidoRepo->getByArbitroByLiga($arbitroId, $ligaId);
			$partidosIds = $this->partidoRepo->getIdsByArbitroByLiga($arbitroId, $ligaId);
			$eventos = $this->eventoPartidoRepo->getByEventosByPartidos($partidosIds, [6,10,11] );
		}

		$totales = (object) array('amarillas'=>0,'dobles_amarillas'=>0,'rojas'=>0,'apariciones'=>0,'goles'=>0);
		$totales->apariciones = count($partidos);

		foreach($eventos as $evento)
		{
			if($evento->evento_id == 6)
			{
				$totales->goles++;;
			}
			elseif($evento->evento_id == 10)
			{
				$totales->amarillas++;;
			}
			elseif($evento->evento_id == 11)
			{
				if($evento->doble_amarilla == 1){
					$totales->dobles_amarillas++;
					$totales->amarillas--;
				}
				else
					$totales->rojas++;
			}
		}

		return view('administracion/EstadisticasArbitros/arbitro_campeonato',compact('totales','arbitro','campeonatoId','ligaId','arbitroId','partidos','campeonatos','campeonato'));


	}


}
