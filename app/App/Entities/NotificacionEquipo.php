<?php

namespace App\App\Entities;

class NotificacionEquipo extends \Eloquent {

	protected $fillable = ['user_id','equipo_id'];

	public $timestamps = false;

	protected $table = 'notificacion_equipo';

	public function usuario()
	{
		return $this->belongsTo(NotificacionUsuario::class,'user_id');
	}

}