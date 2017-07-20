<?php

namespace App\Http\Controllers;

use App\App\Repositories\AlineacionRepo;
use App\App\Managers\AlineacionManager;
use App\App\Entities\Alineacion;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\PartidoRepo;
use App\App\Repositories\PlantillaRepo;

class AlineacionController extends BaseController {

	protected $alineacionRepo;
	protected $partidoRepo;
	protected $plantillaRepo;

	public function __construct(AlineacionRepo $alineacionRepo, PartidoRepo $partidoRepo,
		PlantillaRepo $plantillaRepo)
	{
		$this->alineacionRepo = $alineacionRepo;
		$this->partidoRepo = $partidoRepo;
		$this->plantillaRepo = $plantillaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarAlineacion($partidoId, $eventoId, $equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		if($partido->equipo_local_id == $equipoId){
			$equipo = $partido->equipo_local;
		}
		else{
			$equipo = $partido->equipo_visita;
		}
		$tecnico = $this->alineacionRepo->getTecnico($partidoId, $equipoId);
		$alineacion = $this->alineacionRepo->getAlineacion($partidoId, $equipoId);
		$tecnicos = $this->plantillaRepo->getPersonasByRol($partido->campeonato_id, $equipoId, ['DT'])->pluck('nombreCompletoApellidos','id')->toArray();
		$jugadores = $this->plantillaRepo->getPersonasByRol($partido->campeonato_id, $equipoId, ['J']);

		foreach($alineacion as $a)
		{
			foreach($jugadores as $jugador)
			{
				if($jugador->id == $a->persona_id)
				{
					if($a->es_titular)
					{
						$jugador->inicia = true;
					}
					else
					{
						$jugador->suplente = true;
					}
				}
			}
		}


		$tecnicoId = 0;
		if(!is_null($tecnico)){
			$tecnicoId = $tecnico->id;
		}

		return view('administracion/EventoPartido/alineacion', compact('tecnicos','jugadores','tecnicoId','partidoId','equipoId','eventoId', 'equipo','partido'));
	}

	public function alineacion($partidoId, $eventoId, $equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$data = Input::all();
		$alineacionManager = new AlineacionManager(null, $data);
		$alineacionManager->agregar($partidoId, $equipoId);
		Session::flash('success', 'Se agregó la alineación con éxito.');
		return redirect(route('monitorear_jornada',[$partido->campeonato->liga_id, $partido->campeonato_id, $partido->jornada_id, $partidoId, $equipoId]));
	}

	public function mostrarEditarMinutos($partidoId, $equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		if($partido->equipo_local_id == $equipoId){
			$equipo = $partido->equipo_local;
		}
		else{
			$equipo = $partido->equipo_visita;
		}
		$alineacion = $this->alineacionRepo->getAlineacion($partidoId, $equipoId);
		return view('administracion/EventoPartido/editar_minutos', compact('alineacion','partidoId','equipoId','eventoId', 'equipo','partido'));
	}

	public function editarMinutos($partidoId, $equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$data = Input::all();
		$alineacionManager = new AlineacionManager(null, $data);
		$alineacionManager->editarMinutos($partidoId, $equipoId);
		Session::flash('success', 'Se editaron los minutos de la alineación con éxito.');
		return redirect(route('monitorear_jornada',[$partido->campeonato->liga_id, $partido->campeonato_id, $partido->jornada_id, $partidoId, $equipoId]));
	}


}