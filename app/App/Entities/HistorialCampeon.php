<?php

namespace App\App\Entities;

class HistorialCampeon extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['campeonato','equipo_campeon','entrenador_campeon','equipo_subcampeon','fecha','veces_equipo','veces_entrenador'];

	protected $table = 'historial_campeon';

}