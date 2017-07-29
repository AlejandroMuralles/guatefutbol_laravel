<?php

namespace App\App\Repositories;

use App\App\Entities\Partido;
use App\App\Entities\Persona;

class PartidoRepo extends BaseRepo{

	public function getModel()
	{
		return new Partido;
	}

	public function getByCampeonatoByFase($campeonatoId, $fases)
	{
		return Partido::where('campeonato_id','=',$campeonatoId)
						->whereHas('jornada', function($q) use ($fases) {
							$q->whereIn('fase',$fases);
						})
						->with('equipo_local')
						->with('equipo_visita')
						->orderBy('fecha')
						->get();
	}

	public function getByCampeonatoByFaseByEstado($campeonatoId, $fases, $estados)
	{
		return Partido::where('campeonato_id',$campeonatoId)
						->with('equipo_local')
						->with('equipo_visita')
						->with('arbitro_central')
						->whereHas('jornada',function($q) use ($fases)
							{
								$q->whereIn('fase',$fases);
							})
						->whereIn('estado',$estados)
						->orderBy('fecha')
						->get();
	}

	public function getByCampeonato($campeonatoId)
	{
		$partidos = Partido::where('campeonato_id','=',$campeonatoId)
						->with('jornada')
						->with('equipo_local')
						->with('equipo_visita')
						->with('estadio')
						->orderBy('fecha')
						->get();
		$partidos = $partidos->sortBy(function($partido){
			return $partido->jornada->numero . strtotime($partido->fecha);
		});
		
		return $partidos;

	}

	public function getBetweenFechas($fechaInicio, $fechaFin)
	{
		return Partido::whereBetween('fecha',[$fechaInicio,$fechaFin])
						->with('equipo_local')
						->with('equipo_visita')
						->with('campeonato')
						->with('campeonato.liga')
						->orderBy('fecha')
						->get();
	}

	public function getByCampeonatoByEquipo($campeonatoId, $equipoId)
	{
		return Partido::where('campeonato_id','=',$campeonatoId)
						->whereRaw('(equipo_local_id = '.$equipoId .' OR equipo_visita_id = '.$equipoId.')')
						->with('equipo_local')
						->with('equipo_visita')
						->with('jornada')
						->orderBy('fecha')
						->get();
	}

	public function getByDia()
	{
		return Partido::whereBetween('fecha',[date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
						->orderBy('fecha')
						->get();
	}

	public function getByJornada($campeonatoId, $jornadaId)
	{
		return Partido::where('campeonato_id','=',$campeonatoId)
						->where('jornada_id','=',$jornadaId)
						->with('equipo_local')
						->with('equipo_visita')
						->orderBy('fecha')
						->get();
	}

	public function getOtrosByJornada($campeonatoId, $jornadaId,$partidoId)
	{
		return Partido::where('campeonato_id','=',$campeonatoId)
						->where('jornada_id','=',$jornadaId)
						->where('id','!=',$partidoId)
						->orderBy('fecha')
						->get();
	}

	public function getByCampeonatoByFechas($campeonatoId, $fechaInicio, $fechaFin)
	{
		$partidos = Partido::where('campeonato_id','=',$campeonatoId)
							->whereBetween('fecha',[$fechaInicio, $fechaFin])
							->with('equipo_local')
							->with('equipo_visita')
							->with('jornada')
							->orderBy('fecha')->get();
		$partidos = $partidos->sortBy(function($partido){
			return $partido->jornada->numero . strtotime($partido->fecha);
		});
		return $partidos;
	}

	public function getBetweenEquipos($ligaId, $equipo1Id, $equipo2Id)
	{
		return Partido::whereHas('campeonato',function($q) use($ligaId){
							$q->where('liga_id',$ligaId);
						})
						->whereIn('estado', [2,3])
						->WhereRaw('( ( equipo_local_id = '.$equipo1Id.' AND equipo_visita_id = '.$equipo2Id.' ) OR ( 
										equipo_local_id = '.$equipo2Id.' AND equipo_visita_id = '.$equipo1Id.') )')
						->with('equipo_local')
						->with('equipo_visita')
						->with('jornada')
						->with('campeonato')
						->orderBy('fecha','DESC')
						->get();
	}

	public function getByArbitroByEquipo($arbitroId, $equipoId)
	{
		return Partido::whereIn('estado_id',[2,3])
						->where('arbitro_central_id','=',$arbitroId)
						->whereRaw('( equipo_local_id = '.$equipoId.' OR equipo_visita_id = '.$equipoid.')')
						->orderBy('fecha','DESC')
						->get();
	}

	public function getByArbitroByCampeonato($arbitroId, $campeonatoId)
	{
		return Partido::whereIn('estado',[2,3])
						->where('arbitro_central_id','=',$arbitroId)
						->where('campeonato_id','=',$campeonatoId)
						->orderBy('fecha','DESC')
						->get();
	}

	public function getIdsByArbitroByCampeonato($arbitroId, $campeonatoId)
	{
		return \DB::table('partido')
					->whereIn('estado',[2,3])
					->where('arbitro_central_id','=',$arbitroId)
					->where('campeonato_id','=',$campeonatoId)
					->pluck('id');
	}

	public function getByArbitroByLiga($arbitroId, $ligaId)
	{
		return Partido::whereHas('campeonato',function($q) use($ligaId){
							$q->where('liga_id','=',$ligaId);
						})
						->whereIn('estado',[2,3])
						->where('arbitro_central_id','=',$arbitroId)
						->orderBy('fecha','DESC')
						->get();
	}

	public function getIdsByArbitroByLiga($arbitroId, $ligaId)
	{
		return Partido::whereHas('campeonato',function($q) use($ligaId){
							$q->where('liga_id','=',$ligaId);
						})
						->whereIn('estado',[2,3])
						->where('arbitro_central_id','=',$arbitroId)
						->pluck('id');
	}

	public function getAutocompletePersonas($ligaId, $nombre, $roles)
	{
		$ids = Partido::whereHas('campeonato',function($q) use($ligaId)
									{
										$q->where('liga_id','=',$ligaId);
									})
								->pluck('arbitro_central_id')->toArray();
		$personas = Persona::whereIn('id',$ids)->whereIn('rol_id',$roles)
							->Select(\DB::raw('id, CONCAT(primer_nombre," ",segundo_nombre," ",primer_apellido," ",segundo_apellido) as value'))
							->whereRaw('CONCAT(primer_nombre," ",segundo_nombre," ",primer_apellido," ",segundo_apellido) LIKE \'%'.$nombre.'%\'')
							->take(10)
							->get();
		return $personas;
	}

	public function getByCampeonatosEnAppByFechas($fechaInicio, $fechaFin)
	{
		return Partido::whereBetween('fecha',[$fechaInicio,$fechaFin])
						->whereHas('campeonato', function($q){
							$q->where('mostrar_app',1);
						})
						->with('equipo_local')
						->with('equipo_visita')
						->with('campeonato')
						->with('estadio')
						->with('campeonato.liga')
						->orderBy('fecha')
						->get();
	}

	private function orderByJornada($partidoA, $partidoB)
	{
		if(  $partidoA->jornada->numero ==  $partidoB->jornada->numero ){ return 0 ; } 
  		return ($partidoA->jornada->numero < $partidoB->jornada->numero) ? -1 : 1;
	}

}
