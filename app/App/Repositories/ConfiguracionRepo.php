<?php

namespace App\App\Repositories;

use App\App\Entities\Configuracion;

class ConfiguracionRepo extends BaseRepo{

	public function getModel()
	{
		return new Configuracion;
	}

}