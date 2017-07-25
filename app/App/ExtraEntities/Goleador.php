<?php

namespace App\App\ExtraEntities;

class Goleador {
	
	public $jugador;
	public $equipo;
	public $goles;

	public function __construct($jugador, $equipo)
	{
		$this->jugador = $jugador;
		$this->equipo = $equipo;
		$this->goles = 0;
		$this->minutos = 0;
	}

}