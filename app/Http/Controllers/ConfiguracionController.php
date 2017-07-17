<?php

namespace App\Http\Controllers;

use App\App\Repositories\ConfiguracionRepo;
use App\App\Managers\ConfiguracionManager;
use App\App\Entities\Configuracion;
use Contconfiguracionler, Redirect, Input, View, Session;

class ConfiguracionController extends BaseController {

	protected $configuracionRepo;

	public function __construct(ConfiguracionRepo $configuracionRepo)
	{
		$this->configuracionRepo = $configuracionRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$configuraciones = $this->configuracionRepo->all('nombre');
		return view('administracion/Configuracion/listado', compact('configuraciones'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/Configuracion/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new ConfiguracionManager(new Configuracion(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la configuracion con éxito.');
		return redirect(route('configuraciones'));
	}	

	public function mostrarEditar($id)
	{
		$configuracion = $this->configuracionRepo->find($id);
		return view('administracion/Configuracion/editar', compact('configuracion'));
	}

	public function editar($id)
	{
		$configuracion = $this->configuracionRepo->find($id);
		$data = Input::all();
		$manager = new ConfiguracionManager($configuracion, $data);
		$manager->save();
		Session::flash('success', 'Se editó la configuracion con éxito.');
		return redirect(route('configuraciones'));
	}


}