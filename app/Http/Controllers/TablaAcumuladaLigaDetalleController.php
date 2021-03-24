<?php

namespace App\Http\Controllers;

use App\App\Entities\TablaAcumuladaLiga;
use App\App\Managers\TablaAcumuladaLigaDetalleManager;
use App\App\Entities\TablaAcumuladaLigaDetalle;
use App\App\Repositories\TablaAcumuladaLigaDetalleRepo;

use App\App\Repositories\LigaRepo;
use App\App\Repositories\CampeonatoRepo;


class TablaAcumuladaLigaDetalleController extends BaseController {

	protected $tablaAcumuladaLigaRepo;
	protected $ligaRepo;
	protected $campeonatoRepo;

	public function __construct(TablaAcumuladaLigaDetalleRepo $tablaAcumuladaLigaDetalleRepo, LigaRepo $ligaRepo, CampeonatoRepo $campeonatoRepo)
	{
		$this->tablaAcumuladaLigaDetalleRepo = $tablaAcumuladaLigaDetalleRepo;
		$this->ligaRepo = $ligaRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		view()->composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(TablaAcumuladaLiga $tablaAcumuladaLiga)
	{
		$campeonatos = $this->tablaAcumuladaLigaDetalleRepo->getByTablaAcumuladaLiga($tablaAcumuladaLiga->id);
		return view('administracion/TablaAcumuladaLigaDetalle/listado', compact('campeonatos','tablaAcumuladaLiga'));
	}

	public function mostrarAgregar(TablaAcumuladaLiga $tablaAcumuladaLiga)
	{
		$campeonatos = $this->campeonatoRepo->getByLigaNotInTablaAcumuladaLiga($tablaAcumuladaLiga->liga_id, $tablaAcumuladaLiga->id)->pluck('nombre','id')->toArray();
		return view('administracion/TablaAcumuladaLigaDetalle/agregar', compact('tablaAcumuladaLiga','campeonatos'));
	}

	public function agregar(TablaAcumuladaLiga $tablaAcumuladaLiga)
	{
		$data = request()->all();
		$data['tabla_acumulada_liga_id'] = $tablaAcumuladaLiga->id;
		$data['estado'] = 'A';
		$manager = new TablaAcumuladaLigaDetalleManager(new TablaAcumuladaLigaDetalle(), $data);
		$manager->save();
		session()->flash('success', 'Se agregó la tabla acumulada con éxito.');
		return redirect()->route('tablas_acumuladas_ligas_detalle',$tablaAcumuladaLiga->id);
	}

	public function eliminar(TablaAcumuladaLigaDetalle $tablaAcumuladaLigaDetalle)
	{
		$manager = new TablaAcumuladaLigaDetalleManager($tablaAcumuladaLigaDetalle, null);
		$manager->delete();
		session()->flash('success', 'Se eliminó el campeonato de la tabla acumulada con éxito.');
		return redirect()->route('tablas_acumuladas_ligas_detalle', $tablaAcumuladaLigaDetalle->tabla_acumulada_liga_id);
	}
}
