<?php

namespace App\App\Entities;
use Variable;

class Liga extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','orden','mostrar_app','notificaciones','estado'];

	protected $table = 'liga';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getDescripcionMostrarAppAttribute()
	{
		if($this->mostrar_app)
		{
			return '<i class="fa fa-check square bg-green white"></i>';
		}
		else{
			return '<i class="fa fa-times square bg-red white"></i>';
		}
    }
    
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