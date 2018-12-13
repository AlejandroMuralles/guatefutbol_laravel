<?php

namespace App\App\Entities;

class NotificacionEquipo extends \Eloquent {

	protected $fillable = ['user_app_id','equipo_id'];

	protected $table = 'notificacion_equipo';

	public function user()
	{
		return $this->belongsTo(UserApp::class);
    }
    
    public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

}