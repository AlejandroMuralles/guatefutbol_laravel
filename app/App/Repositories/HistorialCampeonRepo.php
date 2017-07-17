<?php

namespace App\App\Repositories;

use App\App\Entities\HistorialCampeon;

class HistorialCampeonRepo extends BaseRepo{

	public function getModel()
	{
		return new HistorialCampeon;
	}

}