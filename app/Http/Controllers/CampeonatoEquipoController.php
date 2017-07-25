<?php

namespace App\Http\Controllers;

use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Managers\CampeonatoEquipoManager;
use App\App\Entities\CampeonatoEquipo;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\CampeonatoRepo;

class CampeonatoEquipoController extends BaseController {

	protected $campeonatoEquipoRepo;
	protected $campeonatoRepo;

	public function __construct(CampeonatoEquipoRepo $campeonatoEquipoRepo, CampeonatoRepo $campeonatoRepo)
	{
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarAgregar($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$equipos = $this->campeonatoEquipoRepo->getEquiposNotInCampeonato($campeonatoId);
		return view('administracion/CampeonatoEquipo/agregar', compact('campeonato','equipos'));
	}

	public function agregar($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$data = Input::all();
		$manager = new CampeonatoEquipoManager(new CampeonatoEquipo(), $data);
		$manager->agregarEquipos($campeonatoId);
		Session::flash('success', 'Se agregaron los equipos al campeonato con éxito.');
		return redirect(route('campeonatos',$campeonato->liga_id));
	}

	public function mostrarEditar($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$equipos = $this->campeonatoEquipoRepo->getEquipos($campeonatoId);
		return view('administracion/CampeonatoEquipo/editar', compact('campeonato','equipos'));
	}

	public function editar($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$data = Input::all();
		$manager = new CampeonatoEquipoManager(null, $data);
		$manager->eliminarEquipos();
		Session::flash('success', 'Se eliminaron los equipos del campeonato con éxito.');
		return redirect(route('campeonatos', $campeonato->liga_id));
	}

	public function mostrarTrasladarEquipos($campeonatoNuevo, $campeonatoAntiguo)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoNuevo);
		$campeonatos = $this->campeonatoRepo->getByLiga($campeonato->liga_id)->pluck('nombre','id')->toArray();
		$equipos = $this->campeonatoEquipoRepo->getEquipos($campeonatoAntiguo);
		return view('administracion/CampeonatoEquipo/trasladar_equipos', compact('campeonato','campeonatos','equipos','campeonatoAntiguo'));
	}

	public function trasladarEquipos($campeonatoNuevo, $campeonatoAntiguo)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoNuevo);
		$data = Input::all();
		$manager = new CampeonatoEquipoManager(null, $data);
		$manager->trasladarEquipos($campeonatoNuevo, $campeonatoAntiguo);
		Session::flash('success', 'Se eliminaron los equipos del campeonato con éxito.');
		return redirect(route('campeonatos', $campeonato->liga_id));
	}


}