<?php

namespace App\Http\Controllers;

use App\App\Entities\Permiso;
use App\App\Repositories\PermisoRepo;
use App\App\Managers\PermisoManager;

use App\App\Repositories\PerfilRepo;

use View, Input, Session;

class PermisoController extends BaseController {

	protected $permisoRepo;
	protected $perfilRepo;

	public function __construct(PermisoRepo $permisoRepo, PerfilRepo $perfilRepo)
	{
		$this->permisoRepo = $permisoRepo;
		$this->perfilRepo = $perfilRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function permisos($id)
	{
		$perfil = $this->perfilRepo->find($id);
		$modulosPublicos = $this->permisoRepo->getPermisos($id,0);
		$modulosAdmin = $this->permisoRepo->getPermisos($id,1);
		return view('administracion/Perfil/permisos', compact('modulosPublicos', 'modulosAdmin', 'perfil'));
	}

	public function editar($perfilId)
	{
		$perfil = $this->perfilRepo->find($perfilId);
		$data = Input::all();
		$data['vistas'] = array_where($data['vistas'], function($key, $value)
		{
		    return isset($value['checked']);
		});
		$manager = new PermisoManager($perfil, $data);
		$manager->save();
		Session::flash('success', 'Se agregaron los permisos con éxito.');
		return redirect(route('perfiles'));
	}

}
