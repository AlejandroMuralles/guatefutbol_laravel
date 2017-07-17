<?php

namespace App\App\Repositories;

use App\App\Entities\Vista;

class VistaRepo extends BaseRepo{

	public function getModel()
	{
		return new Vista;
	}

}