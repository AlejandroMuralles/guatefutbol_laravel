<?php

namespace App\App\Repositories;

use App\App\Entities\Pais;

class PaisRepo extends BaseRepo{

	public function getModel()
	{
		return new Pais;
	}

}