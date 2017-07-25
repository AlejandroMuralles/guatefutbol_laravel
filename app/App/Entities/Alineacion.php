<?php

namespace App\App\Entities;

class Alineacion extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['partido_id','equipo_id','persona_id','es_titular','minutos_jugados'];

	protected $table = 'alineacion';

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}

	public function partido()
	{
		return $this->belongsTo(Partido::class);
	}

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

}