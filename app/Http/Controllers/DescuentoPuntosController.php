<?php

namespace App\Http\Controllers;

use App\App\Repositories\DescuentoPuntosRepo;
use App\App\Managers\DescuentoPuntosManager;
use App\App\Entities\DescuentoPuntos;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\CampeonatoEquipoRepo;

use App\App\Entities\Liga;

class DescuentoPuntosController extends BaseController {

	protected $descuentoPuntosRepo;
	protected $campeonatoRepo;
	protected $campeonatoEquipoRepo;

	public function __construct(DescuentoPuntosRepo $descuentoPuntosRepo, CampeonatoRepo $campeonatoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo)
	{
		$this->descuentoPuntosRepo = $descuentoPuntosRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Liga $liga)
	{
		$descuentos = $this->descuentoPuntosRepo->getByLiga($liga->id)->load('campeonato')->load('equipo');
		return view('administracion/DescuentoPuntos/listado', compact('descuentos','liga'));
	}

	public function mostrarAgregar(Liga $liga, $campeonatoId)
	{
		$campeonatos = $this->campeonatoRepo->getByLiga($liga->id)->pluck('nombre','id')->toArray();
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$equipos = $this->campeonatoEquipoRepo->getEquiposByCampeonato($campeonatoId)->pluck('nombre','id')->toArray();
		$tipos = Variable::getTiposDescuentoPuntos();
		return view('administracion/DescuentoPuntos/agregar',compact('campeonatos','equipos','liga','campeonato','campeonatoId','tipos'));
	}

	public function agregar(Liga $liga, $campeonatoId)
	{
		$data = Input::all();
		$manager = new DescuentoPuntosManager(new DescuentoPuntos(), $data);
		$descuento = $manager->save();
		Session::flash('success', 'Se agregó el descuento de puntos del equipo '.$descuento->equipo->nombre.' al campeonato '.
										$descuento->campeonato->nombre.' con éxito.');
		return redirect()->route('descuento_puntos',$liga->id);
	}

	public function mostrarEditar(DescuentoPuntos $descuentoPuntos)
	{
		$tipos = Variable::getTiposDescuentoPuntos();
		return view('administracion/DescuentoPuntos/editar', compact('descuentoPuntos','tipos'));
	}

	public function editar(DescuentoPuntos $descuentoPuntos)
	{
		$data = Input::all();
		$data['campeonato_id'] = $descuentoPuntos->campeonato_id;
		$data['equipo_id'] = $descuentoPuntos->equipo_id;
		$manager = new DescuentoPuntosManager($descuentoPuntos, $data);
		$descuento = $manager->save();
		Session::flash('success', 'Se editó el descuento de puntos del equipo '.$descuento->equipo->nombre.' del campeonato '.
										$descuento->campeonato->nombre.' con éxito.');
		return redirect()->route('descuento_puntos',$descuentoPuntos->campeonato->liga_id);
	}


}