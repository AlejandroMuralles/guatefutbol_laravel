<?php

namespace App\Http\Controllers;

use App\App\Repositories\AnuncioRepo;
use App\App\Managers\AnuncioManager;
use App\App\Entities\Anuncio;
use Controller, Redirect, Input, View, Session,Variable;

class AnuncioController extends BaseController {

	protected $anuncioRepo;

	public function __construct(AnuncioRepo $anuncioRepo)
	{
		$this->anuncioRepo = $anuncioRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$anuncios = $this->anuncioRepo->all('anunciante');
		return view('administracion/Anuncio/listado', compact('anuncios'));
	}

	public function mostrarAgregar()
	{
        $pantallas = Variable::getPantallasApp();
        $estados = Variable::getEstadosGenerales();
        $anunciantes = Variable::getTiposAnunciantes();
        $tipos = Variable::getTiposAnuncios();
		return view('administracion/Anuncio/agregar',compact('pantallas','estados','anunciantes','tipos'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new AnuncioManager(new Anuncio(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el anuncio con éxito.');
		return redirect()->route('anuncios');
	}

	public function mostrarEditar(Anuncio $anuncio)
	{
        $pantallas = Variable::getPantallasApp();
        $estados = Variable::getEstadosGenerales();
        $anunciantes = Variable::getTiposAnunciantes();
        $tipos = Variable::getTiposAnuncios();
		return view('administracion/Anuncio/editar', compact('anuncio','pantallas','estados','anunciantes','tipos'));
	}

	public function editar(Anuncio $anuncio)
	{
		$data = Input::all();
		$manager = new AnuncioManager($anuncio, $data);
		$manager->editar();
		Session::flash('success', 'Se editó el anuncio con éxito.');
		return redirect()->route('anuncios');
	}


}