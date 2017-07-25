<?php

namespace App\App\ExtraEntities;

class EquipoPosicion {
	
	public $equipo;
	public $POS;
	public $JJ;
	public $JG;
	public $JP;
	public $JE;
	public $GF;
	public $GC;
	public $DIF;
	public $PTS;

	public function __construct($equipo)
	{
		$this->equipo = $equipo;
		$this->POS = 0;
		$this->JJ = 0;
		$this->JG = 0;
		$this->JP = 0;
		$this->JE = 0;
		$this->GF = 0;
		$this->GC = 0;
		$this->DIF = 0;
		$this->PTS = 0;
	}

}