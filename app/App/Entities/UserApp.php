<?php

namespace App\App\Entities;

class UserApp extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['uuid','fabricante','modelo','plataforma','notificaciones','one_signal_id','utlima_sesion'];

	protected $table = 'users_app';

    public function getDescripcionNotificacionesAttribute()
	{
		if($this->notificaciones)
		{
			return '<i class="fa fa-check square bg-green white"></i>';
		}
		else{
			return '<i class="fa fa-times square bg-red white"></i>';
		}
	}

}