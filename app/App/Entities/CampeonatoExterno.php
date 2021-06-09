<?php

namespace App\App\Entities;
use App\App\Components\Variable;

class CampeonatoExterno extends \Eloquent {

	use UserStamps;

    protected $fillable = ['nombre_liga','nombre','link','estado'];

	protected $table = 'campeonato_externo';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

}