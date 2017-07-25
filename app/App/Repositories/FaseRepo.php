<?php

namespace App\App\Repositories;

use App\App\Entities\Fase;

class FaseRepo extends BaseRepo{

	public function getModel()
	{
		return new Fase;
	}

}