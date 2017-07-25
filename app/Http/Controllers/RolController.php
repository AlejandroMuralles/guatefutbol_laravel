<?php

namespace App\Http\Controllers;

use App\App\Repositories\RolRepo;
use App\App\Managers\RolManager;
use App\App\Entities\Rol;
use Controller, Redirect, Input, View, Session;

class RolController extends BaseController {

	protected $rolRepo;

	public function __construct(RolRepo $rolRepo)
	{
		$this->rolRepo = $rolRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$roles = $this->rolRepo->all('nombre');
		return view('administracion/Rol/listado', compact('roles'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/Rol/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new RolManager(new Rol(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el rol con éxito.');
		return redirect(route('roles'));
	}

	public function mostrarEditar($id)
	{
		$rol = $this->rolRepo->find($id);
		return view('administracion/Rol/editar', compact('rol'));
	}

	public function editar($id)
	{
		$rol = $this->rolRepo->find($id);
		$data = Input::all();
		$manager = new RolManager($rol, $data);
		$manager->save();
		Session::flash('success', 'Se editó el rol con éxito.');
		return redirect(route('roles'));
	}


}