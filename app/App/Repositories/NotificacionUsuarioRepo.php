<?php

namespace App\App\Repositories;

use App\App\Entities\NotificacionUsuario;

class NotificacionUsuarioRepo extends BaseRepo{

	public function getModel()
	{
		return new NotificacionUsuario;
	}

	public function getByUser($user)
	{
		return NotificacionUsuario::where('user','=',$user)->first();
	}

}