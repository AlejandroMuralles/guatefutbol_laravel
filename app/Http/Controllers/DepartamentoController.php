<?php

namespace App\Http\Controllers;

use App\App\Repositories\DepartamentoRepo;
use App\App\Managers\DepartamentoManager;
use App\App\Entities\Departamento;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\PaisRepo;

class DepartamentoController extends BaseController {

	protected $departamentoRepo;
	protected $paisRepo;

	public function __construct(DepartamentoRepo $departamentoRepo, PaisRepo $paisRepo)
	{
		$this->departamentoRepo = $departamentoRepo;
		$this->paisRepo = $paisRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$departamentos = $this->departamentoRepo->all('nombre');
		return view('administracion/Departamento/listado', compact('departamentos'));
	}

	public function mostrarAgregar()
	{
		$paises = $this->paisRepo->lists('nombre','id');
		return view('administracion/Departamento/agregar', compact('paises'));
	}

	public function agregar()
	{
		$data = Input::all();
		$data['estado'] = 'A';
		$manager = new DepartamentoManager(new Departamento(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el departamento con éxito.');
		return redirect(route('departamentos'));
	}

	public function mostrarEditar($id)
	{
		$paises = $this->paisRepo->lists('nombre','id');
		$departamento = $this->departamentoRepo->find($id);
		return view('administracion/Departamento/editar', compact('departamento','paises'));
	}

	public function editar($id)
	{
		$departamento = $this->departamentoRepo->find($id);
		$data = Input::all();
		$data['estado'] = $departamento->estado;
		$manager = new DepartamentoManager($departamento, $data);
		$manager->save();
		Session::flash('success', 'Se editó el departamento con éxito.');
		return redirect(route('departamentos', $departamento->pais_id));
	}


}