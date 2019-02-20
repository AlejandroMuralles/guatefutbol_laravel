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

	protected $tiposDescuentoPuntos = [
		1 => 'SOLO TABLA ACUMULADA',
		2 => 'CAMPEONATO Y TABLA ACUMULADA'
    ];
    
    protected $tiposNotificacion = [
		'tabla_posiciones' => 'Tabla de Posiciones',
		'calendario'  => 'Calendario',
        'link' => 'Link',
        'evento_partido' => 'Evento Partido',
    ];

    protected $tiposAnunciantes = [
		'G' => 'GOOGLE',
        'C' => 'CLIENTE',
    ];

    protected $tiposAnuncios = [
		'GB'    => 'GOOGLE - BANNER',
        'GI'    => 'GOOGLE - INTER',
        'GA'    => 'GOOGLE - BANNER E INTER',
        'CI'    => 'CLIENTE - INTER',
    ];
    
    protected $pantallasApp = [
		1 => 'Inicio',
        2 => 'Calendario',
        3 => 'Posiciones',
        4 => 'Goleadores',
        6 => 'Porteros',
        7 => 'Partido',
        8 => 'Equipos',
        9 => 'Plantilla',
        10 => 'Tabla Acumulada',
        11 => 'Noticias'
    ];

	public function getEstadosGenerales() { return $this->estadosGenerales; }
	public function getEstadoGeneral($key) { return $this->estadosGenerales[$key]; }

	public function getRoles() { return $this->roles; }
	public function getRol($key) { return $this->roles[$key]; }

	public function getEstadosPartidos() { return $this->estadosPartidos; }
	public function getEstadoPartido($key) { return $this->estadosPartidos[$key]; }

	public function getEstadosTiemposPartidos() { return $this->estadosTiemposPartidos; }
	public function getEstadoTiempoPartido($key) { return $this->estadosTiemposPartidos[$key]; }

	public function getTiposDescuentoPuntos() { return $this->tiposDescuentoPuntos; }
    public function getTipoDescuentoPuntos($key) { return $this->tiposDescuentoPuntos[$key]; }
    
    public function getTiposNotificacion(){ return $this->tiposNotificacion; }
    public function getTipoNotificacion($key){ return $this->tiposNotificacion[$key]; }
    
    public function getPantallasApp() { return $this->pantallasApp; }
    public function getPantallaApp($key) { return $this->pantallasApp[$key]; }
    
    public function getTiposAnunciantes(){ return $this->tiposAnunciantes; }
    public function getTipoAnunciante($key){ return $this->tiposAnunciantes[$key]; }

    public function getTiposAnuncios(){ return $this->tiposAnuncios; }
    public function getTipoAnuncio($key){ return $this->tiposAnuncios[$key]; }

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