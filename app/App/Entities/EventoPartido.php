<?php

namespace App\App\Entities;

class EventoPartido extends \Eloquent {

	use UserStamps;

	protected $fillable = ['partido_id','evento_id','minuto','doble_amarilla','jugador1_id','jugador2_id','equipo_id','comentario','estado'];

	protected $table = 'evento_partido';

	public function jugador1()
	{
		return $this->belongsTo(Persona::class, 'jugador1_id');
	}

	public function jugador2()
	{
		return $this->belongsTo(Persona::class, 'jugador2_id');
	}

	public function partido()
	{
		return $this->belongsTo(Partido::class);
	}

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

	public function evento()
	{
		return $this->belongsTo(Evento::class);
	}

}