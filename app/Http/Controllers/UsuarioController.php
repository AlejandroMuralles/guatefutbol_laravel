<?php

namespace App\Http\Controllers;

use App\App\Repositories\UsuarioRepo;
use App\App\Managers\UsuarioManager;
use App\App\Entities\User;

use App\App\Repositories\PerfilRepo;

use Controller, Redirect, Input, View;

class UsuarioController extends BaseController {

	protected $usuarioRepo;
	protected $perfilRepo;

	public function __construct(UsuarioRepo $usuarioRepo, PerfilRepo $perfilRepo)
	{
		$this->usuarioRepo = $usuarioRepo;
		$this->perfilRepo = $perfilRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$usuarios = $this->usuarioRepo->all('username');
		return view('administracion/Usuario/listado', compact('usuarios'));
	}

	public function mostrarAgregar()
	{
		$perfiles = $this->perfilRepo->lists('nombre','id');
		return view('administracion/Usuario/agregar',compact('perfiles'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new UsuarioManager(new User(), $data);
		$manager->save();
		return redirect(route('usuarios'));
	}

	public function mostrarEditar($id)
	{
		$perfiles = $this->perfilRepo->lists('nombre','id');
		$usuario = $this->usuarioRepo->find($id);
		return view('administracion/Usuario/editar', compact('usuario','perfiles'));
	}

	public function editar($id)
	{
		$usuario = $this->usuarioRepo->find($id);
		$data = Input::all();
		$manager = new UsuarioManager($usuario, $data);
		$manager->update();
		return redirect(route('usuarios'));
	}


}