<?php

namespace App\App\ExtraEntities;

class RachaEquipo {
	
	public $equipo;
	public $ganados;
	public $perdidos;
	public $empatados;
	public $goles_favor;
	public $goles_contra;
	public $racha;

	public function __construct($equipo)
	{
		$this->equipo = $equipo;
		$this->ganados = 0;
		$this->perdidos = 0;
		$this->empatados = 0;
		$this->goles_favor = 0;
		$this->goles_contra = 0;
		$this->racha = [];
	}

}