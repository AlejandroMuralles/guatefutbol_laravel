<?php

namespace App\App\Components;

class StaticVariables {

	protected $estadosGenerales = [
		'A' => 'ACTIVO',
		'I' => 'INACTIVO'
	];

	protected $roles = [
		'J' 	=> 'JUGADOR',
		'DT' 	=> 'DIRECTOR TECNICO',
		'A' 	=> 'ARBITRO'
	];

	protected $estadosPartidos = [
		1 	=> 'PROGRAMADO',
		2 	=> 'EN JUEGO',
		3 	=> 'FINALIZADO',
	];

	protected $estadosTiemposPartidos = [
		'P' 	=> 'PROGRAMADO',
		'PT' 	=> 'PRIMER TIEMPO',
		'FPT' 	=> 'FINAL PRIMER TIEMPO',
		'ST' 	=> 'SEGUNDO TIEMPO',
		'FT'	=> 'FINAL PARTIDO',
		'PTE'   => 'PRIMER TIEMPO EXTRA',
		'FPTE'  => 'FINAL PRIMER TIEMPO EXTRA',
		'STE'	=> 'SEGUNDO TIEMPO EXTRA',
	];

	public function getEstadosGenerales() { return $this->estadosGenerales; }
	public function getEstadoGeneral($key) { return $this->estadosGenerales[$key]; }

	public function getRoles() { return $this->roles; }
	public function getRol($key) { return $this->roles[$key]; }

	public function getEstadosPartidos() { return $this->estadosPartidos; }
	public function getEstadoPartido($key) { return $this->estadosPartidos[$key]; }

	public function getEstadosTiemposPartidos() { return $this->estadosTiemposPartidos; }
	public function getEstadoTiempoPartido($key) { return $this->estadosTiemposPartidos[$key]; }

	public function arrayToCommaSeparatedList($array)
	{
		$list = "";
		$i=0;
		foreach($array as $key)
		{
			if($i==0)
				$list = '\''.$key.'\'';
			else
				$list .= ',\''. $key.'\'';
			$i++;
		}
		return $list;
	}

	public function getHorasMinutosSegundosBetweenFechas($fechaInicio, $fechaFin)
	{
		$date1 = new \DateTime($fechaInicio);
		$date2 = new \DateTime($fechaFin);
		$diff = $date1->diff($date2);
		return $diff->h . ":" . $diff->i . ":" . $diff->s;
	}

}