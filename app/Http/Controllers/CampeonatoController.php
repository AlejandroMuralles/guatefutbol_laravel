<?php

namespace App\Http\Controllers;

use App\App\Repositories\CampeonatoRepo;
use App\App\Managers\CampeonatoManager;
use App\App\Entities\Campeonato;
use Controller, Redirect, Input, View, Session,Variable;

use App\App\Repositories\LigaRepo;

class CampeonatoController extends BaseController {

	protected $campeonatoRepo;
	protected $ligaRepo;

	public function __construct(CampeonatoRepo $campeonatoRepo, LigaRepo $ligaRepo)
	{
		$this->campeonatoRepo = $campeonatoRepo;
		$this->ligaRepo = $ligaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($ligaId)
	{
		$campeonatos = $this->campeonatoRepo->getByLiga($ligaId);
		$liga = $this->ligaRepo->find($ligaId);
		return view('administracion/Campeonato/listado', compact('campeonatos','liga'));
	}

	public function mostrarAgregar($ligaId)
	{
		$estados = Variable::getEstadosGenerales();
		$ligas = $this->ligaRepo->lists('nombre','id');
		return view('administracion/Campeonato/agregar', compact('ligas','ligaId','estados'));
	}

	public function agregar($ligaId)
	{
		$data = Input::all();
		$manager = new CampeonatoManager(new Campeonato(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el campeonato con éxito.');
		return redirect(route('campeonatos',$ligaId));
	}

	public function mostrarEditar($id)
	{
		$estados = Variable::getEstadosGenerales();
		$ligas = $this->ligaRepo->lists('nombre','id');
		$campeonato = $this->campeonatoRepo->find($id);
		return view('administracion/Campeonato/editar', compact('campeonato','ligas','estados'));
	}

	public function editar($id)
	{
		$campeonato = $this->campeonatoRepo->find($id);
		$data = Input::all();
		$manager = new CampeonatoManager($campeonato, $data);
		$manager->save();
		Session::flash('success', 'Se editó el campeonato con éxito.');
		return redirect(route('campeonatos', $campeonato->liga_id));
	}


}