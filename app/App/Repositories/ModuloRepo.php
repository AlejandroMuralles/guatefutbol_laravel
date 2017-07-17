<?php

namespace App\App\Repositories;

use App\App\Entities\Modulo;

class ModuloRepo extends BaseRepo{

	public function getModel()
	{
		return new Modulo;
	}

}