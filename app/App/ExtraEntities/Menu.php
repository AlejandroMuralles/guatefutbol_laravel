<?php

namespace App\App\ExtraEntities;

class Menu {
	
	public $modulo;
	public $vistas;

	public function __construct($modulo)
	{
		$this->modulo = $modulo;
		$this->vistas = array();
	}

}