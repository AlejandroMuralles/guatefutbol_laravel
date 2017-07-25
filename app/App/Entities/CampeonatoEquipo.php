<?php

namespace App\App\Entities;

class CampeonatoEquipo extends \Eloquent {

	use UserStamps;

	protected $fillable = ['equipo_id','campeonato_id','estado'];

	protected $table = 'campeonato_equipo';

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

	public function campeonato()
	{
		return $this->belongsTo(Campeonato::class);
	}

}