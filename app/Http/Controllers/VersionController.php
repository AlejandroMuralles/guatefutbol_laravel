<?php

namespace App\Http\Controllers;

use App\App\Repositories\VersionRepo;
use App\App\Managers\VersionManager;
use App\App\Entities\Version;
use App\App\Components\Variable;
use App\App\Managers\SaveDataException;
use Exception;

class VersionController extends BaseController {

	protected $versionRepo;

	public function __construct(VersionRepo $versionRepo)
	{
		$this->versionRepo = $versionRepo;
		view()->composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function ver()
	{
		$version = $this->versionRepo->getVersion();
		return view('administracion/Version/ver', compact('version'));
	}

	public function mostrarAgregar()
	{
		$version = $this->versionRepo->getVersion();
		if(!is_null($version))
			throw new SaveDataException('Error!', new Exception('Ya existe una versión. Favor de actualizarla.'));
		return view('administracion/Version/agregar');
	}

	public function agregar()
	{
		$version = $this->versionRepo->getVersion();
		if(!is_null($version))
			throw new SaveDataException('Error!', new Exception('Ya existe una versión. Favor de actualizarla.'));
		$data = request()->all();
		$manager = new VersionManager(new Version(), $data);
		$manager->save();
		session()->flash('success', 'Se agregó la versión con éxito.');
		return redirect()->route('ver_version');
	}

	public function mostrarEditar()
	{
		$version = $this->versionRepo->getVersion();
		return view('administracion/Version/editar', compact('version'));
	}

	public function editar()
	{
		$version = $this->versionRepo->getVersion();
		$data = request()->all();
		$manager = new VersionManager($version, $data);
		$manager->save();
		session()->flash('success', 'Se editó la versión con éxito.');
		return redirect()->route('ver_version');
	}


}