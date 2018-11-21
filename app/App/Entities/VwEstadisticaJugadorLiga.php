<?php

namespace App\App\Entities;
use Variable;

class VwEstadisticaJugadorLiga extends \Eloquent {

	use UserStamps;

	protected $table = 'vw_estadisticas_jugador_liga';

	public function persona()
	{
		return $this->belongsTo(Persona::class,'id');
	}

	public function getNombreCompletoAttribute()
	{
		$portero = $this->portero ? ' (P)' : '';
		return $this->primer_nombre . ' ' . $this->segundo_nombre . ' ' . $this->primer_apellido . ' ' . $this->segundo_apellido . $portero;
	}

	public function getNombreCortoAttribute()
	{
		$portero = $this->portero ? ' (P)' : '';
		return $this->primer_nombre . ' ' . $this->primer_apellido . $portero;
	}

	public function getNombreCompletoApellidosAttribute()
	{
		$portero = $this->portero ? ' (P)' : '';
		return $this->primer_apellido . ' ' . $this->segundo_apellido . ' ' . $this->primer_nombre . ' ' . $this->segundo_nombre . $portero;
	}

	public function getNombreCortoApellidosAttribute()
	{
		$portero = $this->portero ? ' (P)' : '';
		return $this->primer_apellido . ' ' . $this->primer_nombre . $portero;
	}

}