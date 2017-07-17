<?php

namespace App\Http\Controllers;

use App\App\Repositories\HistorialCampeonRepo;
use App\App\Managers\HistorialCampeonManager;
use App\App\Entities\HistorialCampeon;
use Controller, Redirect, Input, View, Session;


class HistorialCampeonController extends BaseController {

	protected $historialCampeonRepo;

	public function __construct(HistorialCampeonRepo $historialCampeonRepo)
	{
		$this->historialCampeonRepo = $historialCampeonRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$campeones = $this->historialCampeonRepo->all('fecha');
		return view('administracion/HistorialCampeon/listado', compact('campeones'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/HistorialCampeon/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new HistorialCampeonManager(new HistorialCampeon(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el campeón con éxito.');
		return redirect(route('historial_campeones'));
	}

	public function mostrarEditar($id)
	{
		$campeon = $this->historialCampeonRepo->find($id);
		return view('administracion/HistorialCampeon/editar', compact('campeon'));
	}

	public function editar($id)
	{
		$campeon = $this->historialCampeonRepo->find($id);
		$data = Input::all();
		$manager = new HistorialCampeonManager($campeon, $data);
		$manager->save();
		Session::flash('success', 'Se editó el Campeon con éxito.');
		return redirect(route('historial_campeones'));
	}


}