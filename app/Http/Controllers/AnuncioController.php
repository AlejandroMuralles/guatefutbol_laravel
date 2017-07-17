<?php

namespace App\Http\Controllers;

use App\App\Repositories\AnuncioRepo;
use App\App\Managers\AnuncioManager;
use App\App\Entities\Anuncio;
use Controller, Redirect, Input, View, Session;

class AnuncioController extends BaseController {

	protected $anuncioRepo;

	public function __construct(AnuncioRepo $anuncioRepo)
	{
		$this->anuncioRepo = $anuncioRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$anuncios = $this->anuncioRepo->all('nombre');
		return view('administracion/Anuncio/listado', compact('anuncios'));
	}

	public function mostrarAgregar()
	{
		return view('administracion/Anuncio/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new AnuncioManager(new Anuncio(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el anuncio con éxito.');
		return redirect(route('anuncios'));
	}

	public function mostrarEditar($id)
	{
		$anuncio = $this->anuncioRepo->find($id);
		return view('administracion/Anuncio/editar', compact('anuncio'));
	}

	public function editar($id)
	{
		$anuncio = $this->anuncioRepo->find($id);
		$data = Input::all();
		$manager = new AnuncioManager($anuncio, $data);
		$manager->save();
		Session::flash('success', 'Se editó el anuncio con éxito.');
		return redirect(route('anuncios'));
	}

	public function siguiente($anuncioId)
	{
		$anuncio = $this->anuncioRepo->getSiguiente($anuncioId,'I',['A']);
		$anuncio->imagen = asset('assets/imagenes/anuncios').'/'.$anuncio->imagen;
		return json_encode($anuncio);
	}


}