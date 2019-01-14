<?php

namespace App\App\Repositories;

use App\App\Entities\Notificacion;

class NotificacionRepo extends BaseRepo{

	public function getModel()
	{
		return new Notificacion;
	}

}
