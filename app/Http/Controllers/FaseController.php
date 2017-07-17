<?php

namespace App\Http\Controllers;

use App\App\Repositories\FaseRepo;
use App\App\Managers\FaseManager;
use App\App\Entities\Fase;
use Controller, Redirect, Input, View, Session;

class FaseController extends BaseController {

	protected $faseRepo;

	public function __construct(FaseRepo $faseRepo)
	{
		$this->faseRepo = $faseRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$fases = $this->faseRepo->all('nombre');
		return view('administracion/Fase/listado', compact('fases'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/Fase/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new FaseManager(new Fase(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la fase con éxito.');
		return redirect(route('fases'));
	}

	public function mostrarEditar($id)
	{
		$fase = $this->faseRepo->find($id);
		return view('administracion/Fase/editar', compact('fase'));
	}

	public function editar($id)
	{
		$fase = $this->faseRepo->find($id);
		$data = Input::all();
		$manager = new FaseManager($fase, $data);
		$manager->save();
		Session::flash('success', 'Se editó la fase con éxito.');
		return redirect(route('fases'));
	}


}