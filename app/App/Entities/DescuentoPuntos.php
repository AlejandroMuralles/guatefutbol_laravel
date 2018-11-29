<?php

namespace App\App\Entities;
use Variable;

class DescuentoPuntos extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['campeonato_id','equipo_id','tipo','puntos'];

	protected $table = 'descuento_puntos';

	public function campeonato()
	{
		return $this->belongsTo(Campeonato::class);
	}

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

	public function getDescripcionTipoAttribute()
	{
		return Variable::getTipoDescuentoPuntos($this->tipo);
	}

}