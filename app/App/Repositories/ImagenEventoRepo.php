<?php

namespace App\App\Repositories;

use App\App\Entities\ImagenEvento;

class ImagenEventoRepo extends BaseRepo{

	public function getModel()
	{
		return new ImagenEvento;
	}

}