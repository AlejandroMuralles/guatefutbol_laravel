<?php

namespace App\Http\Controllers;

use App\App\Repositories\PlantillaRepo;
use App\App\Managers\PlantillaManager;
use App\App\Entities\Plantilla;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\CampeonatoEquipoRepo;

class PlantillaController extends BaseController {

	protected $campeonatoEquipoRepo;
	protected $plantillaRepo;

	public function __construct(PlantillaRepo $plantillaRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo)
	{
		$this->plantillaRepo = $plantillaRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarAgregar($campeonatoEquipoId)
	{
		$campeonatoEquipo = $this->campeonatoEquipoRepo->find($campeonatoEquipoId);
		$personas = $this->plantillaRepo->getPersonasNotInCampeonato($campeonatoEquipo->campeonato_id);
		return view('administracion/Plantilla/agregar', compact('campeonatoEquipo','personas'));
	}

	public function agregar($campeonatoEquipoId)
	{
		$campeonatoEquipo = $this->campeonatoEquipoRepo->find($campeonatoEquipoId);
		$data = Input::all();
		$manager = new PlantillaManager(new Plantilla(), $data);
		$manager->agregarPersonas($campeonatoEquipo->campeonato_id, $campeonatoEquipo->equipo_id);
		Session::flash('success', 'Se agregaron las personas al equipo con éxito.');
		return redirect(route('editar_equipos_campeonato',$campeonatoEquipo->campeonato_id));
	}

	public function mostrarEditar($campeonatoEquipoId)
	{
		$campeonatoEquipo = $this->campeonatoEquipoRepo->find($campeonatoEquipoId);
		$personas = $this->plantillaRepo->getPersonas($campeonatoEquipo->campeonato_id, $campeonatoEquipo->equipo_id);
		
		return view('administracion/Plantilla/editar', compact('campeonatoEquipo','personas'));
	}

	public function editar($campeonatoEquipoId)
	{
		$campeonatoEquipo = $this->campeonatoEquipoRepo->find($campeonatoEquipoId);
		$data = Input::all();
		$manager = new PlantillaManager(null, $data);
		$manager->eliminarPersonas();
		Session::flash('success', 'Se eliminaron las personas del equipo '.$campeonatoEquipo->equipo->nombre.'del campeonato 
				'.$campeonatoEquipo->campeonato->nombre.'con éxito.');
		return redirect(route('editar_equipos_campeonato', $campeonatoEquipo->campeonato_id));
	}


}