<?php

namespace App\App\Repositories;

use App\App\Entities\Alineacion;
use App\App\Entities\Persona;

class AlineacionRepo extends BaseRepo{

	public function getModel()
	{
		return new Alineacion;
	}

	public function getTecnico($partidoId, $equipoId)
	{
		$alineacion = Alineacion::where('partido_id','=',$partidoId)->where('equipo_id','=',$equipoId)
					->whereHas('persona',function($q)
							{
								$q->where('rol','DT');
							})
					->get();
		if(isset($alineacion[0])){
			return $alineacion[0]->persona;
		}
		return null;
	}

	public function getAlineacion($partidoId, $equipoId)
	{

		$alineacion = Alineacion::where('partido_id','=',$partidoId)
							->where('equipo_id','=',$equipoId)
							->with('persona')
							->whereHas('persona',function($q)
							{
								$q->where('rol','J');
							})
							->get();							
		$alineacion = $alineacion->sortBy(function ($jugador) { return strtolower(utf8_encode($jugador->persona->nombreCompletoApellidos)); });
		return $alineacion;
	}

	public function getAlineacionByEstado($partidoId, $equipoId, $esTitular)
	{

		$alineacion = Alineacion::where('partido_id','=',$partidoId)
							->where('equipo_id','=',$equipoId)
							->where('es_titular','=',$esTitular)
							->whereHas('persona',function($q)
							{
								$q->where('rol','J');
							})
							->get();

		$alineacion = $alineacion->sortBy(function ($jugador) { return strtolower(utf8_encode($jugador->persona->nombreCompletoApellidos)); });
		return $alineacion;
	}

	public function getJugadoresParticipantes($partidoId, $equipoId)
	{
		$alineacion = Alineacion::leftJoin('persona', 'alineacion.persona_id', '=', 'persona.id')
							->where('partido_id','=',$partidoId)
							->where('equipo_id','=',$equipoId)
							->where('es_titular','=',true)
							->whereHas('persona',function($q)
							{
								$q->where('rol','J');
							})
							->with('persona')
							->orderBy('es_titular', 'DESC')
							->orderBy('persona.primer_apellido')
							->orderBy('minutos_jugados','DESC')
							->get();	


		$cambios = Alineacion::where('partido_id','=',$partidoId)
							->where('equipo_id','=',$equipoId)
							->whereRaw('(es_titular = false or es_titular is null)' )
							->where('minutos_jugados','>',0)
							->whereHas('persona',function($q)
							{
								$q->where('rol','J');
							})
							->with('persona')
							->orderBy('minutos_jugados','DESC')
							->get();
		foreach($cambios as $cambio)
		{
			$alineacion->push($cambio);
		}

		return $alineacion;
	}

	public function getListAlineacion($partidoId, $equipoId)
	{
		$ids = \DB::table('alineacion')
					->where('partido_id', '=', $partidoId)
					->where('equipo_id', '=', $equipoId)
					->pluck('persona_id');
    	return Persona::whereIn('id', $ids)
    			->select('id',\DB::raw("
    				IF(portero = 0,
						CONCAT(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre),
						CONCAT(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' (P)')) as nombre"))
    			->orderBy('nombre')
    			->pluck('nombre','id');
	}

	public function getAlineacionByRol($partidoId, $equipoId, $rol)
	{
		$ids = Alineacion::where('partido_id',$partidoId)
					->where('equipo_id',$equipoId)
					->pluck('persona_id');
    	return Persona::whereIn('id', $ids)
    			->where('rol',$rol)
    			->orderBy('primer_nombre')
    			->orderBy('segundo_nombre')
    			->orderBy('primer_apellido')
    			->orderBy('segundo_apellido')
    			->get();
	}

	public function getJugadorByPartido($partidoId, $jugadorId)
	{
		$alineacion = Alineacion::where('partido_id','=',$partidoId)
							->where('persona_id','=',$jugadorId)->get();
		return $alineacion[0];
	}

	public function getMinutosJugados($campeonatoId, $personaId, $fases)
	{

		$alineacion = Alineacion::select(\DB::raw('SUM(minutos_jugados) as minutos_jugados'))
			->where('persona_id','=',$personaId)
			->whereHas('partido',function($q) use ($campeonatoId, $fases){
				$q->where('campeonato_id','=',$campeonatoId)
					->whereHas('jornada', function($w) use($fases){
						$w->whereIn('fase',$fases);
					});
				})->get();

		if(count($alineacion) > 0)
			return intval($alineacion[0]->minutos_jugados);
		return 0;
	}

	public function getApariciones($campeonatoId, $personaId, $fases)
	{
		$alineacion = Alineacion::where('persona_id','=',$personaId)
			->whereHas('partido',function($q) use ($campeonatoId, $fases){
				$q->where('campeonato_id','=',$campeonatoId)
					->whereHas('jornada', function($q) use($fases){
						$q->whereIn('fase',$fases);
					});
				})
			->where('minutos_jugados','>',0)->get();
		return count($alineacion);
	}

	public function getAparicionesByJugadores($campeonatoId, $personasIds, $fases)
	{
		$apariciones = Alineacion::select(\DB::raw('persona_id, COUNT(persona_id) as apariciones'))
								->whereIn('persona_id',$personasIds)
								->whereHas('partido',function($q) use ($campeonatoId, $fases){
									$q->where('campeonato_id','=',$campeonatoId)
										->whereHas('jornada', function($q) use($fases){
										$q->whereIn('fase',$fases);
									});
								})
								->where('minutos_jugados','>',0)
								->groupBy('persona_id')
								->get();
		return $apariciones;
	}

	public function getPartidosByJugadorByLiga($ligaId, $jugadorId)
	{
		return Alineacion::whereHas('partido',function($q) use ($ligaId){
					$q->whereHas('campeonato', function($q) use($ligaId){
						$q->where('liga_id',$ligaId);
					});
				})
				->where('persona_id','=',$jugadorId)
				->where('minutos_jugados','>',0)
				->with('partido')
				->with('partido.equipo_local')
				->with('partido.equipo_visita')
				->with('partido.campeonato')
				->with('equipo')
				->get();
	}

	public function getPartidosByJugadorByCampeonato($campeonatoId, $jugadorId)
	{
		return Alineacion::whereHas('partido',function($q) use ($campeonatoId){
					$q->where('campeonato_id','=',$campeonatoId);
				})
				->where('persona_id','=',$jugadorId)
				->where('minutos_jugados','>',0)
				->with('partido')
				->with('partido.equipo_local')
				->with('partido.equipo_visita')
				->with('partido.campeonato')
				->with('equipo')
				->get();
	}

	public function getPartidosByJugadorByRival($ligaId, $rivalId, $jugadorId)
	{
		return Alineacion::whereHas('partido',function($q) use ($ligaId, $rivalId){
					$q->whereRaw('( equipo_local_id = '.$rivalId.' OR equipo_visita_id = '.$rivalId.' )')
						->whereHas('campeonato',function($q) use ($ligaId){
							$q->where('liga_id','=',$ligaId);
						});
				})
				->where('persona_id','=',$jugadorId)
				->where('minutos_jugados','>',0)
				->where('equipo_id','<>',$rivalId)
				->with('partido')
				->with('partido.equipo_local')
				->with('partido.equipo_visita')
				->with('partido.campeonato')
				->with('equipo')
				->get();
	}

	public function getPartidosByJugadorByEquipo($ligaId, $equipoId, $jugadorId)
	{
		return Alineacion::whereHas('partido',function($q) use ($ligaId, $equipoId){
					$q->whereRaw('( equipo_local_id = '.$equipoId.' OR equipo_visita_id = '.$equipoId.' )')
						->whereHas('campeonato',function($q) use ($ligaId){
							$q->where('liga_id','=',$ligaId);
						});
				})
				->where('persona_id','=',$jugadorId)
				->where('minutos_jugados','>',0)
				->where('equipo_id','=',$equipoId)
				->with('partido')
				->with('partido.equipo_local')
				->with('partido.equipo_visita')
				->with('partido.campeonato')
				->with('equipo')
				->get();
	}

}
