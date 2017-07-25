<?php

namespace App\Http\Controllers;

use App\App\Repositories\EquipoRepo;
use App\App\Managers\EquipoManager;
use App\App\Entities\Equipo;
use Controller, Redirect, Input, View, Session, Variable;

class EquipoController extends BaseController {

	protected $equipoRepo;

	public function __construct(EquipoRepo $equipoRepo)
	{
		$this->equipoRepo = $equipoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$equipos = $this->equipoRepo->all('nombre');
		return view('administracion/Equipo/listado', compact('equipos'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/Equipo/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new EquipoManager(new Equipo(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el equipo con éxito.');
		return redirect(route('equipos'));
	}

	public function mostrarEditar($id)
	{
		$equipo = $this->equipoRepo->find($id);
		$estados = Variable::getEstadosGenerales();
		return view('administracion/Equipo/editar', compact('equipo','estados'));
	}

	public function editar($id)
	{
		$equipo = $this->equipoRepo->find($id);
		$data = Input::all();
		$manager = new EquipoManager($equipo, $data);
		$manager->save();
		Session::flash('success', 'Se editó el equipo con éxito.');
		return redirect(route('equipos'));
	}


}