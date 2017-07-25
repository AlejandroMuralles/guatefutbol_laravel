<?php

namespace App\App\ExtraEntities;

use App\App\Repositories\AlineacionRepo;
use App\App\Repositories\EquipoRepo;
use App\App\Repositories\EventoRepo;
use App\App\Repositories\PersonaRepo;
use App\App\Repositories\EventoPartidoRepo;

class FichaPartido
{

	protected $alineacionRepo;
	protected $equipoRepo;
	protected $eventoRepo;
	protected $personaRepo;


	public $partido;	
	public $dtLocal;
	public $dtVisita;
	public $alineacionLocal;
	public $alineacionVisita;
	public $cambiosLocal;
	public $cambiosVisita;
	public $golesLocal = array();
	public $golesVisita = array();
	public $tarjetasLocal = array();
	public $tarjetasVisita = array();

	public function generarEventos($partido, $eventoss)
	{
		$this->partido = $partido;
		$this->partido->fecha = $this->getFecha($this->partido->fecha);
		$this->alineacionRepo = new AlineacionRepo();
		$this->equipoRepo = new EquipoRepo();
		$this->eventoRepo = new EventoRepo();
		$this->personaRepo = new PersonaRepo();
		$this->eventoPartidoRepo = new eventoPartidoRepo();


		$eventos = $this->eventoPartidoRepo->getByEventos($partido->id, array(6,7,8,9,10,11));
		//getDT
		$this->alineacionLocal = $this->alineacionRepo->getJugadoresParticipantes($partido->id, $partido->equipo_local_id); //dd($this->alineacionLocal);
		//$this->alineacionLocal = $this->alineacionRepo->getAlineacionByEstado($partido->id, $partido->equipo_local_id, true);
		$this->dtLocal = $this->alineacionRepo->getTecnico($partido->id,$partido->equipo_local_id);

		foreach($eventos as $evento)
		{
			if($evento->equipo_id == $partido->equipo_local_id){
				if($evento->evento_id == 6 || $evento->evento_id == 8)
				{
					$this->agregarGol($evento, $this->golesLocal, $this->alineacionLocal);
				}
				else if($evento->evento_id == 7)
				{
					$this->agregarAutoGol($evento, $this->golesLocal);
				}
				else if($evento->evento_id == 10 || $evento->evento_id == 11)
				{
					$this->agregarTarjeta($evento, $this->tarjetasLocal);
				}
				else if($evento->evento_id == 9)
				{
					$this->agregarCambio($evento, $this->alineacionLocal);
				}
			}
		}
		//getDT
		$this->alineacionVisita = $this->alineacionRepo->getJugadoresParticipantes($partido->id, $partido->equipo_visita_id);
		//$this->alineacionVisita = $this->alineacionRepo->getAlineacionByEstado($partido->id, $partido->equipo_visita_id, true);
		$this->dtVisita = $this->alineacionRepo->getTecnico($partido->id,$partido->equipo_visita_id);

		foreach($eventos as $evento)
		{
			if($evento->equipo_id == $partido->equipo_visita_id){
				if($evento->evento_id == 6 || $evento->evento_id == 8 || $evento->id == 7)
				{
					$this->agregarGol($evento, $this->golesVisita, $this->alineacionVisita);
				}
				else if($evento->evento_id == 7)
				{
					$this->agregarAutoGol($evento, $this->golesVisita);
				}
				else if($evento->evento_id == 10 || $evento->evento_id == 11)
				{
					$this->agregarTarjeta($evento, $this->tarjetasVisita);
				}
				else if($evento->evento_id == 9)
				{
					$this->agregarCambio($evento, $this->alineacionVisita);
				}
			}
		}

	}

	public function agregarGol($evento, &$listaGoles, &$alineacion)
	{
		foreach($alineacion as $j)
		{
			if($j->persona_id == $evento->jugador1_id)
			{
				if(!isset($j->goles))
				{
					$j->goles = 0;
				}
				$j->goles++;
			}
		}
		$ngp = new NodoGolPartido();
		$ngp->jugador = $evento->jugador1;
		$ngp->minuto = $evento->minuto;
		$listaGoles[] = $ngp;
	}

	public function agregarAutoGol($evento, &$listaGoles)
	{
		$ngp = new NodoGolPartido();
		$ngp->jugador = $evento->jugador1;
		$ngp->autogol = true;
		$ngp->minuto = $evento->minuto;
		$listaGoles[] = $ngp;
	}

	public function agregarCambio($evento, &$alineacion)
	{
		foreach($alineacion as $j)
		{
			if($j->persona_id == $evento->jugador1_id)
			{
				if(!isset($j->minutoCambio))
				{
					$j->minutoCambio = $evento->minuto;
				}
			}
			if($j->persona_id == $evento->jugador2_id)
			{
				if(!isset($j->minutoCambio))
				{
					$j->minutoCambio = $evento->minuto;
				}
			}
		}
	}

	public function agregarTarjeta($evento, &$listaTarjetas)
	{
		
		$existe = false;
		$ntp = new NodoTarjetaPartido();

		
		foreach($listaTarjetas as $j)
		{
			if($j->jugador->id == $evento->jugador1_id)
			{
				$existe = true;
				$ntp = $j;
			}
		}

		
		$ntp->jugador = $evento->jugador1;
		$minuto = $evento->minuto;
		if($evento->evento_id == 10)
		{			
			$ntp->minutoAmarilla = $minuto;
		}
		else if($evento->evento_id == 11)
		{
			if($evento->doble_amarilla)
			{
				$ntp->minutoDoble = $minuto;
				$ntp->minutoRoja = $minuto;
			}
			else
			{
				$ntp->minutoRoja = $minuto;
			}
		}
		if(!$existe)
			$listaTarjetas[] = $ntp;
	}

	public function getFecha($fecha) {
		$time = strtotime($fecha);
        $dia = date('w',$time);
        $diaSemana = "";
        $ano = date('Y',$time);
        $mes = date('m',$time);
        $hora = date('H:i',$time);
        
        switch ($dia) { 
            case 0: $diaSemana = "Domingo"; break;
            case 1: $diaSemana = "Lunes"; break;
            case 2: $diaSemana = "Martes"; break;
            case 3: $diaSemana = "Miercoles"; break;
            case 4: $diaSemana = "Jueves"; break;
            case 5: $diaSemana = "Viernes"; break;
            case 6: $diaSemana = "Sabado";
        }
        $dia = date('d',$time);

        switch ($mes) { 
            case 1: $mes = "Enero"; break;
            case 2: $mes = "Febrero"; break;
            case 3: $mes = "Marzo"; break;
            case 4: $mes = "Abril"; break;
            case 5: $mes = "Mayo"; break;
            case 6: $mes = "Junio"; break;
            case 7: $mes = "Julio"; break;
            case 8: $mes = "Agosto"; break;
            case 9: $mes = "Septiembre"; break;
            case 10: $mes = "Octubre"; break;
            case 11:$mes = "Noviembre"; break;
            case 12:$mes = "Diciembre";
        }
        return $diaSemana . " " . $dia . " de " . $mes . " de " . $ano . "; " . $hora . " horas";
    }

}