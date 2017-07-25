<?php

namespace App\Http\Controllers;

use App\App\Repositories\ModuloRepo;
use App\App\Managers\ModuloManager;
use App\App\Entities\Modulo;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\GrupoModuloRepo;

class ModuloController extends BaseController {

	protected $moduloRepo;

	public function __construct(ModuloRepo $moduloRepo)
	{
		$this->moduloRepo = $moduloRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$modulos = $this->moduloRepo->all('nombre');
		return view('administracion/Modulo/listado', compact('modulos'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/Modulo/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new ModuloManager(new Modulo(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el modulo con éxito.');
		return redirect(route('modulos'));
	}

	public function mostrarEditar($id)
	{
		$modulo = $this->moduloRepo->find($id);
		return view('administracion/Modulo/editar', compact('modulo'));
	}

	public function editar($id)
	{
		$modulo = $this->moduloRepo->find($id);
		$data = Input::all();
		$manager = new ModuloManager($modulo, $data);
		$manager->save();
		Session::flash('success', 'Se editó el modulo con éxito.');
		return redirect(route('modulos'));
	}


}