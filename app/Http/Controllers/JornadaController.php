<?php

namespace App\Http\Controllers;

use App\App\Repositories\JornadaRepo;
use App\App\Managers\JornadaManager;
use App\App\Entities\Jornada;
use Controller, Redirect, Input, View, Session;

class JornadaController extends BaseController {

	protected $jornadaRepo;

	public function __construct(JornadaRepo $jornadaRepo)
	{
		$this->jornadaRepo = $jornadaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$jornadas = $this->jornadaRepo->all('nombre');
		return view('administracion/Jornada/listado', compact('jornadas'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/Jornada/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new JornadaManager(new Jornada(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la jornada con éxito.');
		return redirect(route('jornadas'));
	}

	public function mostrarEditar($id)
	{
		$jornada = $this->jornadaRepo->find($id);
		return view('administracion/Jornada/editar', compact('jornada'));
	}

	public function editar($id)
	{
		$jornada = $this->jornadaRepo->find($id);
		$data = Input::all();
		$manager = new JornadaManager($jornada, $data);
		$manager->save();
		Session::flash('success', 'Se editó la jornada con éxito.');
		return redirect(route('jornadas'));
	}


}