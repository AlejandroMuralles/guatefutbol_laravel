<?php

namespace App\Http\Controllers;

use App\App\Repositories\EventoPartidoRepo;
use App\App\Managers\EventoPartidoManager;
use App\App\Entities\EventoPartido;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\PartidoRepo;
use App\App\Repositories\EventoRepo;
use App\App\Repositories\PlantillaRepo;
use App\App\Repositories\AlineacionRepo;

use App\App\Managers\PartidoManager;

class EventoPartidoController extends BaseController {

	protected $eventoPartidoRepo;
	protected $partidoRepo;
	protected $eventoRepo;
	protected $alineacionRepo;
	protected $plantillaRepo;

	public function __construct(EventoPartidoRepo $eventoPartidoRepo, PartidoRepo $partidoRepo, EventoRepo $eventoRepo, 
		PlantillaRepo $plantillaRepo, AlineacionRepo $alineacionRepo)
	{
		$this->eventoPartidoRepo = $eventoPartidoRepo;
		$this->partidoRepo = $partidoRepo;
		$this->eventoRepo = $eventoRepo;
		$this->alineacionRepo = $alineacionRepo;
		$this->plantillaRepo = $plantillaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($partidoId)
	{
		$eventos = $this->eventoPartidoRepo->getByPartido($partidoId);
		$partido = $this->partidoRepo->find($partidoId);
		return view('administracion/EventoPartido/listado', compact('eventos','partido'));
	}

	/* Agregar eventos que no necesitan persona. Inicio partido, finaliza primer tiempo, etc. */
	public function mostrarAgregar($partidoId,$eventoId,$equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$evento = $this->eventoRepo->find($eventoId);
		return view('administracion/EventoPartido/agregar', compact('partido','partidoId','evento','equipoId','imagenes'));
	}

	/* Agregar eventos que necesitan persona, goles, autogoles, amarillas. */
	public function mostrarAgregarPersona($partidoId,$eventoId,$equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$evento = $this->eventoRepo->find($eventoId);
		$jugadoresBanca = [];
		$jugadoresContrarios = [];
		if($equipoId == $partido->equipo_local_id) 
			$equipo = $partido->equipo_local; 
		else 
			$equipo = $partido->equipo_visita;

		if($eventoId == 7 || $eventoId == 20) //autogol y encajar gol
		{
			if($equipoId == $partido->equipo_local_id)
			{
				$jugadores = $this->alineacionRepo->getAlineacionByRol($partido->id, $partido->equipo_visita_id,'J')->pluck('nombreCompletoApellidos','id')->toArray();;
				$jugadoresContrarios = $this->alineacionRepo->getListAlineacion($partido->id, $partido->equipo_visita_id)->toArray();
			}
			else
			{

				$jugadores = $this->alineacionRepo->getAlineacionByRol($partido->id, $partido->equipo_local_id,'J')->pluck('nombreCompletoApellidos','id')->toArray();
				$jugadoresContrarios = $this->alineacionRepo->getListAlineacion($partido->id, $partido->equipo_local_id)->toArray();
			}
		}
		else
		{			
			if($eventoId == 9)
			{
				$jugadores = $this->eventoPartidoRepo->getJugadoresEnCampo($partidoId, $equipoId)->pluck('nombreCompletoApellidos','id')->toArray();;
				$jugadoresBanca = $this->eventoPartidoRepo->getJugadoresEnBanca($partidoId, $equipoId)->pluck('nombreCompletoApellidos','id')->toArray();
			}
			else
			{
				$jugadores = $this->alineacionRepo->getAlineacionByRol($partido->id, $equipoId, 'J')->pluck('nombreCompletoApellidos','id')->toArray();
				if($equipoId == $partido->equipo_local_id)
					$jugadoresContrarios = $this->alineacionRepo->getAlineacionByRol($partido->id, $partido->equipo_visita_id,'J')->pluck('nombreCompletoApellidos','id')->toArray();
				else
					$jugadoresContrarios = $this->alineacionRepo->getAlineacionByRol($partido->id, $partido->equipo_local_id,'J')->pluck('nombreCompletoApellidos','id')->toArray();
			}
		}

		return view('administracion/EventoPartido/agregar_persona', compact('partido','partidoId','jugadores','evento','equipo','equipoId',
			'imagenes','jugadoresBanca', 'jugadoresContrarios'));
	}

	public function agregar($partidoId,$eventoId,$equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$evento = $this->eventoRepo->find($eventoId);
		$data = Input::all();
		$data['evento_id'] = $eventoId;
		$data['partido_id'] = $partidoId;
		$manager = new EventoPartidoManager(new EventoPartido(), $data);
		/* Inicio de partido, final primer tiempo, inicio segundo tiempo, inicio primer tiempo extra, fin primer tiempo extra, inicio segundo tiempo extra */
		if($eventoId == 2 || $eventoId == 3 || $eventoId == 4 || $eventoId == 12 || $eventoId == 13 || $eventoId == 14 || $eventoId == 15 || $eventoId == 17 || $eventoId == 18)
		{
			$manager->agregar($partido);
		}
		/* final de partido */
		else if($eventoId == 5 || $eventoId == 16)
		{
			$manager->finalizarPartido($partido);
		}

		
		Session::flash('success', 'Se agregó el evento '.$evento->nombre.' con éxito.');
		return redirect(route('monitorear_jornada',[$partido->campeonato->liga_id, $partido->campeonato_id, $partido->jornada_id, $partidoId, $equipoId]));
	}

	public function agregarPersona($partidoId,$eventoId,$equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$evento = $this->eventoRepo->find($eventoId);
		$data = Input::all();
		$data['evento_id'] = $eventoId;
		$data['partido_id'] = $partidoId;
		$data['equipo_id'] = $equipoId;
		if($eventoId == 9){
			$data['jugador1_id'] = $data['jugador_entra'];
			$data['jugador2_id'] = $data['jugador_sale'];
		}
		$manager = new EventoPartidoManager(new EventoPartido(), $data);
		$manager->agregarPersona($partido,$equipoId);
		Session::flash('success', 'Se agregó el evento '.$evento->nombre.' con éxito.');
		return redirect(route('monitorear_jornada',[$partido->campeonato->liga_id, $partido->campeonato_id, $partido->jornada_id, $partidoId, $equipoId]));
	}

	public function mostrarEditar($id)
	{
		$evento = $this->eventoPartidoRepo->find($id);
		$partido = $this->partidoRepo->find($evento->partido_id);
		return view('administracion/EventoPartido/editar', compact('evento','partido'));
	}

	public function editar($id)
	{
		$evento = $this->eventoPartidoRepo->find($id);
		$partido = $this->partidoRepo->find($evento->partido_id);
		$data = Input::all();
		$data['evento_id'] = $evento->evento_id;
		$data['partido_id'] = $evento->partido_id;
		$manager = new EventoPartidoManager($evento, $data);
		$manager->save();
		Session::flash('success', 'Se editó el evento con éxito.');
		return redirect(route('eventos_partido', $evento->partido_id));
	}

	public function mostrarEditarPersona($id)
	{
		$evento = $this->eventoPartidoRepo->find($id);
		$partido = $this->partidoRepo->find($evento->partido_id);
		if($partido->equipo_local_id == $evento->equipo_id)
		{
			$equipo = $partido->equipo_local;
		}
		else
		{
			$equipo = $partido->equipo_visita;
		}
		if($evento->evento_id == 7) //autogol
		{
			if($evento->equipo_id == $partido->equipo_local_id)
			{
				$jugadores = $this->alineacionRepo->getListAlineacion($partido->id, $partido->equipo_visita_id);
			}
			else
			{
				$jugadores = $this->alineacionRepo->getListAlineacion($partido->id, $partido->equipo_local_id);
			}
		}
		else
		{
			$jugadores = $this->alineacionRepo->getListAlineacion($partido->id, $evento->equipo_id);
		}
		$jugadores = $jugadores->toArray();
		return view('administracion/EventoPartido/editar_persona', compact('evento','partido','jugadores','equipo'));
	}

	public function editarPersona($id)
	{
		$evento = $this->eventoPartidoRepo->find($id);
		$partido = $this->partidoRepo->find($evento->partido_id);
		$data = Input::all();
		$data['evento_id'] = $evento->evento_id;
		$data['partido_id'] = $evento->partido_id;
		$data['equipo_id'] = $evento->equipo_id;
		$manager = new EventoPartidoManager($evento, $data);
		$manager->save();
		Session::flash('success', 'Se editó el evento con éxito.');
		return redirect(route('eventos_partido', $evento->partido_id));
	}

	public function eliminarEvento($id)
	{
		$evento = $this->eventoPartidoRepo->find($id);
		$partido = $this->partidoRepo->find($evento->partido_id);
		$data = Input::all();
		$manager = new EventoPartidoManager($evento, $data);
		$manager->eliminarEvento($partido);
		Session::flash('success', 'Se eliminó el evento con éxito.');
		return redirect(route('eventos_partido', $evento->partido_id));
	}

	public function mostrarModificarPartido($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		return view('administracion/EventoPartido/modificar_partido', compact('partido'));
	}

	public function modificarPartido($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$data = Input::all();
		if($data['descripcion_penales'] == '') $data['descripcion_penales'] = null;
		$data['fecha'] = $partido->fecha;
		$data['equipo_local_id'] = $partido->equipo_local_id;
		$data['equipo_visita_id'] = $partido->equipo_visita_id;
		$data['campeonato_id'] = $partido->campeonato_id;
		$data['estado'] = $partido->estado;
		$data['estado_tiempo'] = $partido->estado_tiempo;
		$data['jornada_id'] = $partido->jornada_id;
		$data['arbitro_central_id'] = $partido->arbitro_central_id;
		$manager = new PartidoManager($partido, $data);
		$manager->save();
		Session::flash('success', 'Se editó el partido con éxito.');
		return redirect(route('monitorear_jornada',[$partido->campeonato->liga_id, $partido->campeonato_id, $partido->jornada_id, $partidoId, $partido->equipo_local_id]));
	}


}