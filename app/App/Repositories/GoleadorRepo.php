<?php

namespace App\App\Repositories;

use App\App\Repositories\EventoPartidoRepo;
use App\App\ExtraEntities\Goleador;
use App\App\Entities\Alineacion;

class GoleadorRepo {

	protected $goleadores;

	public function getGoleadores($campeonato)
	{
		$this->goleadores = array();
		$eventoPartidoRepo = new EventoPartidoRepo();

		$goles = $eventoPartidoRepo->getByCampeonatoByFase($campeonato->id, array(6,8), array('R'));

		foreach($goles as $gol)
		{
			$goleador = $this->getGoleador($gol->jugador1, $gol->equipo);
			$goleador->goles = $goleador->goles + 1;
		}

		$ids = [];
		foreach($this->goleadores as $goleador){
			if(strtotime($campeonato->fecha_fin) > strtotime(date('Y-m-d H:i:s')))
			{
				$diff = abs(strtotime($campeonato->fecha_fin) - strtotime($goleador->jugador->fecha_nacimiento));
				$goleador->jugador->fecha_nacimiento = intval($diff/60/60/24/365);
			}
			else
			{
				$diff = abs(strtotime(date("Y-m-d H:i:s")) - strtotime($goleador->jugador->fecha_nacimiento));
				$goleador->jugador->fecha_nacimiento = intval($diff/60/60/24/365);
			}
			$ids[] = $goleador->jugador->id;
			//$goleador->minutos = $this->getMinutosJugados($campeonato->id, $goleador->jugador->id, 2);
		}

		$minutosJugados = $this->getMinutosJugados($campeonato->id, $ids, ['R']);

		foreach($minutosJugados as $mj)
		{
			foreach($this->goleadores as $goleador)
			{
				if($goleador->jugador->id == $mj->persona_id){
					$goleador->minutos = $mj->minutos_jugados;
				}
			}
		}
		usort($this->goleadores, array('App\App\Repositories\GoleadorRepo','cmp'));

		return $this->goleadores;
	}

	function cmp( $a, $b ) {
		if ($a->goles == $b->goles) {

			if($a->minutos == $b->minutos)
	  			return strcmp($a->jugador->nombreCompleto, $b->jugador->nombreCompleto);
	  		return $a->minutos < $b->minutos ? -1 : 1;
   		}
		return $a->goles > $b->goles ? -1 : 1;
	}

	public function getGoleador($jugador, $equipo)
	{
		foreach($this->goleadores as $goleador)
		{
			if($goleador->jugador->id == $jugador->id)
			{
				return $goleador;
			}
		}
		$g = new Goleador($jugador, $equipo);
		$this->goleadores[] = $g;
		return $g;
	}

	/*public function getMinutosJugados($campeonatoId, $personaId, $fasesId)
	{
		$sql = "
			SELECT SUM(minutos_jugados) minutos
			FROM partido p, alineacion a, jornada j
			WHERE p.campeonato_id = " . $campeonatoId . "
				AND p.jornada_id = j.id
				AND a.partido_id = p.id
				AND j.fase_id IN (".$fasesId.")
				AND a.persona_id = " . $personaId
		;
		$minutos = \DB::select(\DB::raw($sql));
		return intval($minutos[0]->minutos);
	}*/

	public function getMinutosJugados($campeonatoId, $personasIds, $fases)
	{

		$alineaciones = Alineacion::select(\DB::raw('persona_id, SUM(minutos_jugados) as minutos_jugados'))
			->whereIn('persona_id',$personasIds)
			->whereHas('partido',function($q) use ($campeonatoId, $fases){
				$q->where('campeonato_id','=',$campeonatoId)
					->whereHas('jornada', function($q) use($fases){
						$q->whereIn('fase',$fases);
					});
				})
				->groupBy('persona_id')
				->get();
		return $alineaciones;
	}

}
