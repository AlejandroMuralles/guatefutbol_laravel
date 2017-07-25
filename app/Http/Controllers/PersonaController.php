<?php

namespace App\Http\Controllers;

use App\App\Repositories\PersonaRepo;
use App\App\Managers\PersonaManager;
use App\App\Entities\Persona;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\PaisRepo;
use App\App\Repositories\DepartamentoRepo;

class PersonaController extends BaseController {

	protected $personaRepo;
	protected $paisRepo;
	protected $departamentoRepo;

	public function __construct(PersonaRepo $personaRepo, PaisRepo $paisRepo, DepartamentoRepo $departamentoRepo)
	{
		$this->personaRepo = $personaRepo;
		$this->paisRepo = $paisRepo;
		$this->departamentoRepo = $departamentoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$personas = $this->personaRepo->all('primer_nombre');
		return view('administracion/Persona/listado', compact('personas'));
	}

	public function mostrarAgregar()
	{
		$roles = Variable::getRoles();
		$paises = $this->paisRepo->lists('nombre','id');
		$departamentos = $this->departamentoRepo->lists('nombre','id');
		return view('administracion/Persona/agregar',compact('roles','paises','departamentos'));
	}

	public function agregar()
	{
		$data = Input::all();
		$data['estado']=  'A';
		$manager = new PersonaManager(new Persona(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la persona con éxito.');
		return redirect(route('personas'));
	}

	public function mostrarEditar($id)
	{
		$roles = Variable::getRoles();
		$estados = Variable::getEstadosGenerales();
		$paises = $this->paisRepo->lists('nombre','id');
		$persona = $this->personaRepo->find($id);
		$departamentos = $this->departamentoRepo->lists('nombre','id');
		return view('administracion/Persona/editar', compact('persona','roles','paises','departamentos','estados'));
	}

	public function editar($id)
	{
		$persona = $this->personaRepo->find($id);
		$data = Input::all();
		$manager = new PersonaManager($persona, $data);
		$manager->save();
		Session::flash('success', 'Se editó la persona con éxito.');
		return redirect(route('personas'));
	}


}