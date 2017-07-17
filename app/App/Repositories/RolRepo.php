<?php

namespace App\App\Repositories;

use App\App\Entities\Rol;

class RolRepo extends BaseRepo{

	public function getModel()
	{
		return new Rol;
	}

}