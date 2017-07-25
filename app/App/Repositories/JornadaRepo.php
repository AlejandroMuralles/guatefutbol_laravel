<?php

namespace App\App\Repositories;

use App\App\Entities\Jornada;

class JornadaRepo extends BaseRepo{

	public function getModel()
	{
		return new Jornada;
	}

}