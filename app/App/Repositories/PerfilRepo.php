<?php

namespace App\App\Repositories;

use App\App\Entities\Perfil;


class PerfilRepo extends BaseRepo{

	public function getModel()
	{
		return new Perfil;
	}

}