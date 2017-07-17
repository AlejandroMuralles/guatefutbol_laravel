<?php

namespace App\App\Entities;

class Plantilla extends \Eloquent {

	use UserStamps;

	protected $fillable = ['equipo_id','campeonato_id','persona_id','estado'];

	protected $table = 'plantilla';

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}

	public function campeonato()
	{
		return $this->belongsTo(Campeonato::class);
	}

}