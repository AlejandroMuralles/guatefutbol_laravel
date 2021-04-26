<?php

namespace App\Http\Controllers;

use App\App\Repositories\EventoRepo;
use App\App\Managers\EventoManager;
use App\App\Entities\Evento;
use Controller, Redirect, Input, View, Session, Variable;

class EventoController extends BaseController {

	protected $eventoRepo;

	public function __construct(EventoRepo $eventoRepo)
	{
		$this->eventoRepo = $eventoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$eventos = $this->eventoRepo->all('nombre');
		return view('administracion/Evento/listado', compact('eventos'));
	}

	public function mostrarEditar(Evento $evento)
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/Evento/editar', compact('evento','estados'));
	}

	public function editar(Evento $evento)
	{
		$data = Input::all();
		$manager = new EventoManager($evento, $data);
		$manager->save();
		Session::flash('success', 'Se editó el evento con éxito.');
		return redirect(route('eventos'));
	}


}