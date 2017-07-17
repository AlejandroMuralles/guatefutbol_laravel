<?php

namespace App\Http\Controllers;

use App\App\Repositories\EstadioRepo;
use App\App\Managers\EstadioManager;
use App\App\Entities\Estadio;
use Controller, Redirect, Input, View, Session;

class EstadioController extends BaseController {

	protected $estadioRepo;

	public function __construct(EstadioRepo $estadioRepo)
	{
		$this->estadioRepo = $estadioRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$estadios = $this->estadioRepo->all('nombre');
		return view('administracion/Estadio/listado', compact('estadios'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/Estadio/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$data['estado'] = 'A';
		$manager = new EstadioManager(new Estadio(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el estadio con éxito.');
		return redirect(route('estadios'));
	}

	public function mostrarEditar($id)
	{
		$estadio = $this->estadioRepo->find($id);
		return view('administracion/Estadio/editar', compact('estadio'));
	}

	public function editar($id)
	{
		$estadio = $this->estadioRepo->find($id);
		$data = Input::all();
		$manager = new EstadioManager($estadio, $data);
		$manager->save();
		Session::flash('success', 'Se editó el estadio con éxito.');
		return redirect(route('estadios'));
	}


}