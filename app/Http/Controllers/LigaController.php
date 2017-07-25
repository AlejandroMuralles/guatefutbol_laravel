<?php

namespace App\Http\Controllers;

use App\App\Repositories\LigaRepo;
use App\App\Managers\LigaManager;
use App\App\Entities\Liga;
use Controller, Redirect, Input, View, Session,Variable;

class LigaController extends BaseController {

	protected $ligaRepo;

	public function __construct(LigaRepo $ligaRepo)
	{
		$this->ligaRepo = $ligaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$ligas = $this->ligaRepo->all('nombre');
		return view('administracion/Liga/listado', compact('ligas'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/Liga/agregar',compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new LigaManager(new Liga(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la liga con éxito.');
		return redirect(route('ligas'));
	}

	public function mostrarEditar($id)
	{
		$estados = Variable::getEstadosGenerales();
		$liga = $this->ligaRepo->find($id);
		return view('administracion/Liga/editar', compact('liga','estados'));
	}

	public function editar($id)
	{
		$liga = $this->ligaRepo->find($id);
		$data = Input::all();
		$manager = new LigaManager($liga, $data);
		$manager->save();
		Session::flash('success', 'Se editó la liga con éxito.');
		return redirect(route('ligas'));
	}


}