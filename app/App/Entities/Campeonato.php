<?php

namespace App\App\Entities;
use Variable;

class Campeonato extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','fecha_inicio','fecha_fin','liga_id','actual','mostrar_app','hashtag','grupos','estado'];

	protected $table = 'campeonato';

	public function liga()
	{
		return $this->belongsTo(Liga::class);
	}

	public function equipos()
	{
		return $this->belongsToMany(Equipo::class, 'campeonato_equipo');
	}

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getDescripcionActualAttribute()
	{
		if($this->actual)
		{
			return '<i class="fa fa-check square bg-green white"></i>';
		}
		else{
			return '<i class="fa fa-times square bg-red white"></i>';
		}
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

}