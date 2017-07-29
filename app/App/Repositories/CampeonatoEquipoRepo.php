<?php

namespace App\App\Repositories;

use App\App\Entities\CampeonatoEquipo;
use App\App\Entities\Equipo;
use App\App\Entities\Campeonato;
use App\App\ExtraEntities\EquipoPosicion;

class CampeonatoEquipoRepo extends BaseRepo{

	public function getModel()
	{
		return new CampeonatoEquipo;
	}

	public function getEquipos($campeonatoId)
	{
		return CampeonatoEquipo::where('campeonato_id','=',$campeonatoId)->with('equipo')
					->get();
	}

	public function getEquipoInCampeonato($campeonatoId, $equipoId)
	{
		$equipo = CampeonatoEquipo::where('campeonato_id','=',$campeonatoId)
								->where('equipo_id','=',$equipoId)->get();
    	if(count($equipo) > 0){
    		return $equipo[0];
    	}
    	return null;
	}

	public function getEquiposByCampeonato($campeonatoId)
	{
		$ids = \DB::table('campeonato_equipo')
					->where('campeonato_id', '=', $campeonatoId)
					->pluck('equipo_id');
    	return Equipo::whereIn('id', $ids)->orderBy('nombre')->get();
	}

	public function getEquiposNotInCampeonato($campeonatoId)
	{
		$ids = \DB::table('campeonato_equipo')
					->where('campeonato_id', '=', $campeonatoId)
					->pluck('equipo_id');
    	return Equipo::whereNotIn('id', $ids)->get();
	}

	public function getEquiposWithPosiciones($campeonatoId)
	{
		 $equiposCampeonato = CampeonatoEquipo::where('campeonato_id',$campeonatoId)->with('equipo')->get();
		 $equipos = array();
		 foreach($equiposCampeonato as $equipo)
		 {
		 	$e = new EquipoPosicion($equipo->equipo);
		 	$equipos[] = $e;
		 }		 
		 return $equipos;
	}

	public function getByCampeonato($campeonatoId)
	{
		$ids = \DB::table('campeonato_equipo')
					->where('campeonato_id', '=', $campeonatoId)
					->pluck('equipo_id');
    	return Equipo::whereIn('id', $ids)->orderBy('nombre');
	}

	public function getByLiga($ligaId)
	{
		$ids = CampeonatoEquipo::whereHas('campeonato', function($q) use($ligaId){
						$q->where('liga_id',$ligaId);
					})
					->pluck('equipo_id');
    	return Equipo::whereIn('id', $ids)->orderBy('nombre')->get();
	}

}