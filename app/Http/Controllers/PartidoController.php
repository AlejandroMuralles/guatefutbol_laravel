<?php

namespace App\Http\Controllers;

use App\App\Repositories\PartidoRepo;
use App\App\Managers\PartidoManager;
use App\App\Entities\Partido;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\PersonaRepo;
use App\App\Repositories\EstadioRepo;
use App\App\Repositories\JornadaRepo;
use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\EventoRepo;
use App\App\Repositories\LigaRepo;

class PartidoController extends BaseController {

	protected $partidoRepo;
	protected $personaRepo;
	protected $estadioRepo;
	protected $jornadaRepo;
	protected $campeonatoRepo;
	protected $campeonatoEquipoRepo;
	protected $eventoRepo;
	protected $ligaRepo;

	public function __construct(PartidoRepo $partidoRepo, PersonaRepo $personaRepo, EstadioRepo $estadioRepo, JornadaRepo $jornadaRepo,
		CampeonatoRepo $campeonatoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, EventoRepo $eventoRepo, LigaRepo $ligaRepo)
	{
		$this->partidoRepo = $partidoRepo;
		$this->personaRepo = $personaRepo;
		$this->estadioRepo = $estadioRepo;
		$this->jornadaRepo = $jornadaRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->eventoRepo = $eventoRepo;
		$this->ligaRepo = $ligaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($campeonatoId)
	{
		$jornadas = $this->jornadaRepo->lists('nombre','id');
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$partidos = $this->partidoRepo->getByCampeonato($campeonatoId);
		return view('administracion/Partido/listado', compact('partidos','campeonato','jornadas'));
	}

	public function mostrarAgregar($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$arbitros = $this->personaRepo->getByRol(['A'])->pluck('NombreCompletoApellidos','id')->toArray();
		$estadios = $this->estadioRepo->orderList('nombre','nombre','id');
		$jornadas = $this->jornadaRepo->lists('nombre','id');
		$equipos = $campeonato->equipos->pluck('nombre','id')->toArray();
		return view('administracion/Partido/agregar',compact('arbitros','estadios','jornadas','campeonato','equipos'));
	}

	public function agregar($campeonatoId)
	{
		$data = Input::all();
		$data['campeonato_id'] = $campeonatoId;
		$data['estado'] = 1;
		$data['estado_tiempo'] = 'P';
		$data['fecha'] = $data['fecha'] . ' ' . $data['hora'];
		$manager = new PartidoManager(new Partido(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el partido con éxito.');
		return redirect(route('agregar_partido_campeonato',$campeonatoId));
	}

	public function mostrarEditar($id)
	{
		$partido = $this->partidoRepo->find($id);
		$campeonato = $this->campeonatoRepo->find($partido->campeonato_id);
		$arbitros = array();
		$estadios = $this->estadioRepo->lists('nombre','id');
		$jornadas = $this->jornadaRepo->lists('nombre','id');
		$equipos = $campeonato->equipos->pluck('nombre','id')->toArray();
		return view('administracion/Partido/editar', compact('partido','campeonato','arbitros','estadios','jornadas','campeonato','equipos'));
	}

	public function editar($id)
	{
		$partido = $this->partidoRepo->find($id);
		$data = Input::all();
		$data['fecha'] = $data['fecha']. ' '. $data['hora'];
		$data['campeonato_id'] = $partido->campeonato_id;
		$data['estado'] = $partido->estado;
		$data['estado_tiempo'] = $partido->estado_tiempo;
		$manager = new PartidoManager($partido, $data);
		$manager->save();
		Session::flash('success', 'Se editó el partido con éxito.');
		return redirect(route('partidos_campeonato',$partido->campeonato_id));
	}

	public function eliminar()
	{
		$id = Input::get('id_eliminar');
		$partido = $this->partidoRepo->find($id);
		$manager = new PartidoManager($partido, null);
		$manager->eliminar();
		Session::flash('success', 'Se eliminó el partido con éxito.');
		return redirect(route('partidos_campeonato',$partido->campeonato_id));
	}

	public function monitorear($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$eventos = $this->eventoRepo->all('id');
		return view('administracion/Partido/monitorear', compact('partido','eventos'));
	}

	public function mostrarAgregarJornada($campeonatoId, $numeroPartidos)
	{
		$jornadas = $this->jornadaRepo->lists('nombre','id');
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$equipos = $campeonato->equipos;
		$arbitros = $this->personaRepo->getByRolOrderApellido(['A']);
		$estadios = $this->estadioRepo->all('nombre');
		return view('administracion/Partido/agregar_jornada', compact('arbitros','campeonato','jornadas', 'numeroPartidos','equipos','estadios'));
	}

	public function agregarJornada($campeonatoId, $numeroPartidos){
		$data = Input::all();
		$manager = new PartidoManager(null, $data);
		$manager->agregarJornada($campeonatoId, $data);
		Session::flash('success', 'Se agregó la jornada con éxito.');
		return Redirect::back();
	}

	public function mostrarEditarJornada($campeonatoId, $jornadaId)
	{
		$jornada = $this->jornadaRepo->find($jornadaId);
		$jornadas = $this->jornadaRepo->lists('nombre','id');
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$partidos = $this->partidoRepo->getByJornada($campeonatoId,$jornadaId);
		$arbitros = $this->personaRepo->getByRolOrderApellido(['A']);
		$estadios = $this->estadioRepo->all('nombre');
		return view('administracion/Partido/editar_jornada', compact('partidos','arbitros','jornada','campeonato','jornadas','jornadaId','estadios'));
	}

	public function editarJornada($campeoantoId, $jornadaId){
		$data = Input::all();
		$manager = new PartidoManager(null, $data);
		$manager->editarJornada($data);
		Session::flash('success', 'Se editó la jornada con éxito.');
		return Redirect::back();
	}

	public function mostrarMonitorearJornada($ligaId, $campeonatoId, $jornadaId, $partidoId, $equipoId)
	{
		$ligas = $this->ligaRepo->lists('nombre','id');

		$jornadas = $this->jornadaRepo->lists('nombre','id');

		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
			$campeonatoId = $campeonato->id;
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}

		$campeonatos = $this->campeonatoRepo->getByLiga($ligaId)->pluck('nombre','id')->toArray();
		$partidos = $this->partidoRepo->getByJornada($campeonatoId, $jornadaId);
		$partido = $this->partidoRepo->find($partidoId);
		$eventos = $this->eventoRepo->all('id');
		return view('administracion/Partido/monitorear_jornada', compact('partido','eventos','jornadas','ligas','campeonatos','partidos',
					'ligaId','campeonatoId','jornadaId','equipoId'));
	}


}
