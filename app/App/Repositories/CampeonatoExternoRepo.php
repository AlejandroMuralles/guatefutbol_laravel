<?php

namespace App\App\Repositories;

use App\App\Entities\CampeonatoExterno;

class CampeonatoExternoRepo extends BaseRepo {

	public function getModel()
	{
		return new CampeonatoExterno;
	}

	public function getByEstado($estados)
	{
		return CampeonatoExterno::whereIn('estado',$estados)->get();
	}
}