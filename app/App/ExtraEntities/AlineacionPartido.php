<?php

namespace App\App\ExtraEntities;

class AlineacionPartido{

	public $jugador;
	public $amarillas = [];
	public $roja = null;
	public $expulsado = false;
	public $goles = [];
	public $cambio = false;
	public $minuto_cambio = null;

	function __construct($jugador){
		$this->jugador = $jugador;
	}

}