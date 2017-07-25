<?php

namespace App\Http\Controllers;

use App\App\Repositories\PaisRepo;
use App\App\Managers\PaisManager;
use App\App\Entities\Pais;
use Controller, Redirect, Input, View, Session;

class PaisController extends BaseController {

	protected $paisRepo;

	public function __construct(PaisRepo $paisRepo)
	{
		$this->paisRepo = $paisRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$paises = $this->paisRepo->all('nombre');
		return view('administracion/Pais/listado', compact('paises'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/Pais/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$data['estado'] = 'A';
		$manager = new PaisManager(new Pais(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el pais con éxito.');
		return redirect(route('paises'));
	}

	public function mostrarEditar($id)
	{
		$pais = $this->paisRepo->find($id);
		return view('administracion/Pais/editar', compact('pais'));
	}

	public function editar($id)
	{
		$pais = $this->paisRepo->find($id);
		$data = Input::all();
		$data['estado'] = $pais->estado;
		$manager = new PaisManager($pais, $data);
		$manager->save();
		Session::flash('success', 'Se editó el pais con éxito.');
		return redirect(route('paises'));
	}


}