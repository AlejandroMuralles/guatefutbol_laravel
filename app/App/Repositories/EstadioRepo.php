<?php

namespace App\App\Repositories;

use App\App\Entities\Estadio;

class EstadioRepo extends BaseRepo{

	public function getModel()
	{
		return new Estadio;
	}

}