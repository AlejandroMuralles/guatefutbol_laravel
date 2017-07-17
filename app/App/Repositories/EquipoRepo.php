<?php

namespace App\App\Repositories;

use App\App\Entities\Equipo;

class EquipoRepo extends BaseRepo{

	public function getModel()
	{
		return new Equipo;
	}

}