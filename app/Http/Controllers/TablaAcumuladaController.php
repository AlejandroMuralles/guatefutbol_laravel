<?php

namespace App\Http\Controllers;

use App\App\Repositories\TablaAcumuladaRepo;
use App\App\Managers\TablaAcumuladaManager;
use App\App\Entities\TablaAcumulada;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\LigaRepo;
use App\App\Repositories\CampeonatoRepo;

class TablaAcumuladaController extends BaseController {

	protected $tablaAcumuladaRepo;
	protected $ligaRepo;
	protected $campeonatoRepo;

	public function __construct(TablaAcumuladaRepo $tablaAcumuladaRepo, LigaRepo $ligaRepo, CampeonatoRepo $campeonatoRepo)
	{
		$this->tablaAcumuladaRepo = $tablaAcumuladaRepo;
		$this->ligaRepo = $ligaRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($ligaId)
	{
		$tablasAcumuladas = $this->tablaAcumuladaRepo->getByLiga($ligaId);
		$liga = $this->ligaRepo->find($ligaId);
		return view('administracion/TablaAcumulada/listado', compact('tablasAcumuladas','liga'));
	}

	public function mostrarAgregar($ligaId)
	{
		$liga = $this->ligaRepo->find($ligaId);
		$campeonatos = $this->campeonatoRepo->getByLiga($ligaId)->pluck('nombre','id')->toArray();
		return view('administracion/TablaAcumulada/agregar', compact('liga','campeonatos'));
	}

	public function agregar($ligaId)
	{
		$data = Input::all();
		$data['estado'] = 'A';
		$manager = new tablaAcumuladaManager(new tablaAcumulada(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la tabla acumulada con éxito.');
		return Redirect::route('tablas_acumuladas',$ligaId);
	}

	public function mostrarEditar($id)
	{
		$tablaAcumulada = $this->tablaAcumuladaRepo->find($id);
		$liga = $this->ligaRepo->find($tablaAcumulada->campeonato1->liga_id);
		$campeonatos = $this->campeonatoRepo->getByLiga($liga->id)->pluck('nombre','id')->toArray();
		return view('administracion/TablaAcumulada/editar', compact('tablaAcumulada','liga','campeonatos'));
	}

	public function editar($id)
	{
		$tablaAcumulada = $this->tablaAcumuladaRepo->find($id);
		$data = Input::all();
		$data['estado'] = 'A';
		$manager = new tablaAcumuladaManager($tablaAcumulada, $data);
		$manager->save();
		Session::flash('success', 'Se editó la tabla acumulada con éxito.');
		return Redirect::route('tablas_acumuladas', $tablaAcumulada->liga_id);
	}
}
