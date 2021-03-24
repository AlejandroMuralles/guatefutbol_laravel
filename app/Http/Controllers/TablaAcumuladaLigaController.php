<?php

namespace App\Http\Controllers;

use App\App\Entities\Liga;
use App\App\Repositories\TablaAcumuladaLigaRepo;
use App\App\Managers\TablaAcumuladaLigaManager;
use App\App\Entities\TablaAcumuladaLiga;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\LigaRepo;
use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\PartidoRepo;
use App\App\Repositories\PosicionesRepo;
use App\App\Repositories\TablaAcumuladaLigaDetalleRepo;

class TablaAcumuladaLigaController extends BaseController {

	protected $tablaAcumuladaLigaRepo;
	protected $ligaRepo;
	protected $campeonatoRepo;
	protected $tablaAcumuladaLigaDetalleRepo;
	protected $campeonatoEquipoRepo;
	protected $partidoRepo;
	protected $posicionesRepo;

	public function __construct(TablaAcumuladaLigaRepo $tablaAcumuladaLigaRepo, LigaRepo $ligaRepo, CampeonatoRepo $campeonatoRepo,
								TablaAcumuladaLigaDetalleRepo $tablaAcumuladaLigaDetalleRepo, PartidoRepo $partidoRepo,
								CampeonatoEquipoRepo $campeonatoEquipoRepo, PosicionesRepo $posicionesRepo)
	{
		$this->tablaAcumuladaLigaRepo = $tablaAcumuladaLigaRepo;
		$this->ligaRepo = $ligaRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		$this->tablaAcumuladaLigaDetalleRepo = $tablaAcumuladaLigaDetalleRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->partidoRepo = $partidoRepo;
		$this->posicionesRepo = $posicionesRepo;
		view()->composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Liga $liga)
	{
		$tablasAcumuladas = $this->tablaAcumuladaLigaRepo->getByLiga($liga->id);
		return view('administracion/TablaAcumuladaLiga/listado', compact('tablasAcumuladas','liga'));
	}

	public function mostrarAgregar(Liga $liga)
	{
		$campeonatos = $this->campeonatoRepo->getByLiga($liga->id);
		return view('administracion/TablaAcumuladaLiga/agregar', compact('liga','campeonatos'));
	}

	public function agregar(Liga $liga)
	{
		$data = request()->all();
		$data['liga_id'] = $liga->id;
		$data['estado'] = 'A';
		$manager = new TablaAcumuladaLigaManager(new TablaAcumuladaLiga(), $data);
		$manager->agregar();
		session()->flash('success', 'Se agregó la tabla acumulada con éxito.');
		return redirect()->route('tablas_acumuladas_ligas',$liga->id);
	}

	public function mostrarEditar(TablaAcumuladaLiga $tablaAcumuladaLiga)
	{
		return view('administracion/TablaAcumuladaLiga/editar', compact('tablaAcumulada','liga'));
	}

	public function editar(TablaAcumuladaLiga $tablaAcumuladaLiga)
	{
		$data = request()->all();
		$data['liga_id'] = $tablaAcumuladaLiga->liga_id;
		$data['estado'] = 'A';
		$manager = new TablaAcumuladaLigaManager($tablaAcumuladaLiga, $data);
		$manager->save();
		session()->flash('success', 'Se editó la tabla acumulada con éxito.');
		return redirect()->route('tablas_acumuladas_ligas', $tablaAcumuladaLiga->liga_id);
	}

	public function mostrarTabla(TablaAcumuladaLiga $tablaAcumuladaLiga)
	{
		$campeonatos = $this->tablaAcumuladaLigaDetalleRepo->getByTablaAcumuladaLiga($tablaAcumuladaLiga->id);
		$campeonatosIds = $campeonatos->pluck('campeonato_id');
		$partidos = $this->partidoRepo->getByCampeonatosByFaseByEstado($campeonatosIds, ['R'], [2,3]);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosicionesByCampeonatos($campeonatosIds);
		$posiciones = $this->posicionesRepo->getTabla(null, 0, $partidos, $equipos, 1, $campeonatos);
		return view('administracion/TablaAcumuladaLiga/acumulada', compact('posiciones','tablaAcumuladaLiga'));
	}
}
