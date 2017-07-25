<?php

namespace App\App\Repositories;

use App\App\Entities\User;

class UsuarioRepo extends BaseRepo{

	public function getModel()
	{
		return new User;
	}

}