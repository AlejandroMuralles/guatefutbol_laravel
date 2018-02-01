<?php

namespace App\App\Repositories;

use App\App\Entities\EventoPartido;
use App\App\Entities\Persona;

class EventoPartidoRepo extends BaseRepo{

	public function getModel()
	{
		return new EventoPartido;
	}

	public function getByPartido($partidoId)
	{
		return EventoPartido::where('partido_id','=',$partidoId)
					->with('evento')
					->orderBy('minuto','DESC')
					->orderBy('id','DESC')
					->get();
	}

	public function getEnVivo($partidoId)
	{
		return EventoPartido::where('partido_id','=',$partidoId)
					->where('evento_id','!=',20)
					->with('evento')
					->orderBy('minuto','DESC')
					->orderBy('id','DESC')
					->get();
	}

	public function getByCampeonato($campeonatoId, $eventos)
	{
		return EventoPartido::whereHas('partido',function($q) use ($campeonatoId)
							{
								$q->where('campeonato_id','=',$campeonatoId);
							})
							->whereIn('evento_id',$eventos)
							->with('evento')
							->with('jugador1')
							->with('jugador2')
							->with('partido')
							->with('equipo')
							->get();
	}

	public function getByCampeonatoByFase($campeonatoId, $eventos, $fases)
	{
		return EventoPartido::whereIn('evento_id',$eventos)
							->whereHas('partido',function($q) use ($campeonatoId, $fases)
							{
								$q->where('campeonato_id',$campeonatoId);
								$q->whereHas('jornada', function($w) use ($fases){
									$w->whereIn('fase',$fases);
								});
							})
							->with('evento')
							->with('jugador1')
							->with('jugador2')
							->with('partido')
							->with('equipo')
							->get();
	}

	public function getByPersonaByCampeonato($campeonatoId, $jugadorId, $eventos)
	{
		return EventoPartido::whereHas('partido', function($q) use ($campeonatoId)
					{
						$q->where('campeonato_id','=',$campeonatoId);
					})
					->whereIn('evento_id',$eventos)
					->where('jugador1_id','=',$jugadorId)
					->get();
	}

	public function getByPersonasByCampeonato($campeonatoId, $jugadoresIds, $eventos)
	{
		return EventoPartido::whereHas('partido', function($q) use ($campeonatoId)
					{
						$q->where('campeonato_id','=',$campeonatoId);
					})
					->whereIn('evento_id',$eventos)
					->whereIn('jugador1_id',$jugadoresIds)
					->get();
	}

	public function getByEventos($partidoId, $eventos)
	{
		return EventoPartido::where('partido_id',$partidoId)
							->with('jugador1')
							->with('evento')
							->whereIn('evento_id',$eventos)
							->orderBy('minuto','ASC')
							->get();
	}

	public function getByEventosByPartidos($partidos, $eventos)
	{
		return EventoPartido::whereIn('partido_id',$partidos)
							->whereIn('evento_id',$eventos)
							->get();
	}

	public function getByEventosByEquipo($partidoId, $eventos, $equipoId)
	{
		return EventoPartido::where('partido_id','=',$partidoId)
							->whereIn('evento_id',$eventos)
							->with('jugador1')
							->with('jugador2')
							->where('equipo_id','=',$equipoId)
							->orderBy('minuto','ASC')
							->get();
	}

	public function getPersonasWithEventoByPartido($eventos, $partidoId)
	{

		$jugadores1 = EventoPartido::whereIn('evento_id',$eventos)
									->where('partido_id','=',$partidoId)
									->get();

		$jugadores2 = EventoPartido::whereIn('evento_id',$eventos)
									->where('partido_id','=',$partidoId)
									->get();

		$personas = [];
		foreach($jugadores1 as $jugador)
		{
			$personas[] = $jugador->jugador1;
		}

		foreach($jugadores2 as $jugador)
		{
			$exists = false;
			foreach($jugadores1 as $jugador1)
			{
				if($jugador1->jugador1_id == $jugador->jugador2_id)
				{
					$exists = true;
				}
			}
			if(!$exists && !is_null($jugador->jugador2))
			{
				$personas[] =  $jugador->jugador2;
			}
		}
		return $personas;
	}

	public function getAllByEventoByPartidoByPersona($eventos, $partidoId, $jugadorId)
	{
		return EventoPartido::whereIn('evento_id',$eventos)
								->where('partido_id','=',$partidoId)
								->whereRaw('(jugador1_id = '.$jugadorId.' or jugador2_id = '.$jugadorId.')')
								->orderBy('minuto')->get();
	}

	public function getJugadoresEnCampo($partidoId, $equipoId)
	{
		$jugadoresExpulsados = \DB::table('evento_partido')
									->where('evento_id','=',11)
									->where('partido_id','=',$partidoId)
									->where('equipo_id','=',$equipoId)
									->pluck('jugador1_id');
		$jugadoresSalieronDeCambio = \DB::table('evento_partido')
									->where('evento_id','=',9)
									->where('partido_id','=',$partidoId)
									->where('equipo_id','=',$equipoId)
									->pluck('jugador2_id');
		$alineacion = \DB::table('alineacion')
									->where('partido_id','=',$partidoId)
									->where('equipo_id','=',$equipoId)
									->whereNotIn('persona_id',$jugadoresExpulsados)
									->whereNotIn('persona_id',$jugadoresSalieronDeCambio)
									->where('minutos_jugados','!=',0)->pluck('persona_id');

		$personas = Persona::whereIn('id', $alineacion)
				->orderBy('primer_nombre')
    			->orderBy('segundo_nombre')
    			->orderBy('primer_apellido')
    			->orderBy('segundo_apellido')->get();
    	return $personas;
	}

	public function getJugadoresEnBanca($partidoId, $equipoId)
	{
		$jugadoresExpulsados = \DB::table('evento_partido')
									->where('evento_id','=',11)
									->where('partido_id','=',$partidoId)
									->where('equipo_id','=',$equipoId)
									->pluck('jugador1_id');
		$jugadoresEntraronDeCambio = \DB::table('evento_partido')
									->where('evento_id','=',9)
									->where('partido_id','=',$partidoId)
									->where('equipo_id','=',$equipoId)
									->pluck('jugador1_id');

		$alineacion = \DB::table('alineacion')
									->where('partido_id','=',$partidoId)
									->where('equipo_id','=',$equipoId)
									->whereNotIn('persona_id',$jugadoresExpulsados)
									->whereNotIn('persona_id',$jugadoresEntraronDeCambio)
									->whereRaw('(es_titular=0 or es_titular is null)')
									->pluck('persona_id');

		$personas = Persona::whereIn('id', $alineacion)
    			->orderBy('primer_nombre')
    			->orderBy('segundo_nombre')
    			->orderBy('primer_apellido')
    			->orderBy('segundo_apellido')->get();

    	return $personas;

	}

}
