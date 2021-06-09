<?php

namespace App\Http\Controllers;

use App\App\Repositories\CampeonatoExternoRepo;
use App\App\Managers\CampeonatoExternoManager;
use App\App\Entities\CampeonatoExterno;
use App\App\Components\Variable;

class CampeonatoExternoController extends BaseController {

	protected $CampeonatoExternoRepo;

	public function __construct(CampeonatoExternoRepo $CampeonatoExternoRepo)
	{
		$this->CampeonatoExternoRepo = $CampeonatoExternoRepo;
		view()->composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$campeonatos = $this->CampeonatoExternoRepo->all('nombre');
		return view('administracion/CampeonatoExterno/listado', compact('campeonatos'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/CampeonatoExterno/agregar');
	}

	public function agregar()
	{
		$data = request()->all();
		$data['estado'] = 'A';
		$manager = new CampeonatoExternoManager(new CampeonatoExterno(), $data);
		$manager->save();
		session()->flash('success', 'Se agregó el campeonato externo con éxito.');
		return redirect()->route('campeonatos_externos');
	}

	public function mostrarEditar(CampeonatoExterno $campeonatoExterno)
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/CampeonatoExterno/editar', compact('campeonatoExterno','estados'));
	}

	public function editar($id)
	{
		$CampeonatoExterno = $this->CampeonatoExternoRepo->find($id);
		$data = request()->all();
		$manager = new CampeonatoExternoManager($CampeonatoExterno, $data);
		$manager->save();
		session()->flash('success', 'Se editó el campeonato externo con éxito.');
		return redirect()->route('campeonatos_externos');
	}


}