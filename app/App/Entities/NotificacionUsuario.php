<?php

namespace App\App\Entities;

class NotificacionUsuario extends \Eloquent {

	protected $fillable = ['user','token'];
	
	public $timestamps = false;

	protected $table = 'notificacion_usuario';

}