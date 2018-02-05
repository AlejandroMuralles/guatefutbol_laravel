<?php

namespace App\App\Repositories;

use App\App\Entities\Plantilla;
use App\App\Entities\Persona;
use App\App\Entities\Campeonato;
use App\App\Repositories\AlineacionRepo;
use App\App\Repositories\EventoPartidoRepo;

use App\App\Entities\Alineacion;

class PlantillaRepo extends BaseRepo{

	public function getModel()
	{
		return new Plantilla;
	}

	public function getPersonas($campeonatoId, $equipoId)
	{
		$personas = Plantilla::where('campeonato_id',$campeonatoId)
						->where('equipo_id',$equipoId)
						->with('persona')
						->whereHas('persona',function($q){
							$q->with('rol');
						})
						->get();
		$personas = $personas->sortBy(function ($persona) { return strtolower(utf8_encode($persona->persona->nombreCompletoApellidos)); });
		return $personas;
	}

	public function getPersonasByRol($campeonatoId, $equipoId, $roles)
	{
		$ids = Plantilla::where('campeonato_id',$campeonatoId)
						->where('equipo_id',$equipoId)
						->pluck('persona_id');

		return Persona::whereIn('id', $ids)
    			->whereIn('rol',$roles)
    			->with('pais')
				->with('departamento')
    			->orderBy('primer_apellido')->orderBy('segundo_apellido')->orderBy('primer_nombre')->orderBy('segundo_nombre')
    			->get();
	}

	public function getListPersonasByRol($campeonatoId, $equipoId, $roles)
	{

		return $this->getPersonasByRol($campeonatoId, $equipoId, $roles)->pluck('nombreCompletoApellidos','id');

		$ids = \DB::table('plantilla')
					->where('campeonato_id', '=', $campeonatoId)
					->where('equipo_id', '=', $equipoId)
					->pluck('persona_id');
    	return Persona::whereIn('id', $ids)
    			->select('id',\DB::raw("CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido) as nombre"))
    			->whereIn('rol',$roles)
    			->orderBy('nombre')
    			->pluck('nombre','id');
	}

	public function getListPersonas($campeonatoId, $equipoId)
	{
		return $this->getPersonas($campeonatoId, $equipoId)->pluck('persona.nombreCompletoApellidos','id');

		$ids = \DB::table('plantilla')
					->where('campeonato_id', $campeonatoId)
					->where('equipo_id', $equipoId)
					->pluck('persona_id');
    	return Persona::whereIn('id', $ids)
    			->select('id',\DB::raw("CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido) as nombre"))
    			->orderBy('nombre')
    			->pluck('nombre','id');
	}

	public function getPersonasNotInCampeonato($campeonatoId)
	{
		$ids = \DB::table('plantilla')
					->where('campeonato_id',$campeonatoId)
					->pluck('persona_id');
    	return Persona::whereNotIn('id', $ids)->get();
	}

	public function getPlantilla($campeonato, $equipoId)
	{
		$alineacionRepo = new AlineacionRepo();
		$jugadores = $this->getPersonasByRol($campeonato->id, $equipoId, ['J']);

		$jugadoresIds = [];
		foreach($jugadores as $jugador){
			$jugadoresIds[] = $jugador->id;
		}

		$alineacionRepo = new AlineacionRepo();
		$eventoPartidoRepo = new eventoPartidoRepo();

		$minutosJugados = $this->getMinutosJugados($campeonato->id, $jugadoresIds, ['R','F']);
		$apariciones = $alineacionRepo->getAparicionesByJugadores($campeonato->id, $jugadoresIds, ['R','F']);
		$eventos = $eventoPartidoRepo->getByPersonasByCampeonato($campeonato->id, $jugadoresIds, [6,8,10,11]);

		foreach($jugadores as $jugador){

			$jugador->apariciones = 0;
			$jugador->minutos_jugados = 0;

			foreach($minutosJugados as $mj){
				if($mj->persona_id == $jugador->id){
					$jugador->minutos_jugados = is_null($mj->minutos_jugados) ? 0 : $mj->minutos_jugados;
					break;
				}
			}

			foreach($apariciones as $ap){
				if($ap->persona_id == $jugador->id){
					$jugador->apariciones = $ap->apariciones;
					break;
				}
			}

			$goles = 0; $amarillas = 0; $doblesamarillas = 0; $rojas = 0;
			foreach($eventos as $evento)
			{
				if($jugador->id == $evento->jugador1_id){
					if($evento->evento_id == 6 || $evento->evento_id == 8) $goles++;
					if($evento->evento_id == 10) $amarillas++;
					if($evento->evento_id == 11){
						if($evento->doble_amarilla){ $doblesamarillas++; $amarillas--; }
						else $rojas++;
					}
				}
			}
			$jugador->goles = $goles;
			$jugador->amarillas = $amarillas;
			$jugador->rojas = $rojas;
			$jugador->doblesamarillas = $doblesamarillas;

			if(strtotime($campeonato->fecha_fin) > time() ){
				$jugador->edad = intval( (time() - strtotime($jugador->fecha_nacimiento))/60/60/24/365 );
			}
			else{
				$jugador->edad = intval( (strtotime($campeonato->fecha_fin) - strtotime($jugador->fecha_nacimiento))/60/60/24/365 );
			}
		}
		return $jugadores;
	}

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

	public function getAutocompletePersonas($ligaId, $nombre, $roles)
	{
		$nombre = str_replace("+"," ",$nombre);
		$personas = \DB::table('plantilla')
						->join('persona','persona.id','plantilla.persona_id')
						->join('campeonato','campeonato.id','plantilla.campeonato_id')
						->whereIn('persona.rol',$roles)
						->where('campeonato.liga_id',$ligaId)
						->whereRaw('CONCAT(primer_nombre," ",segundo_nombre," ",primer_apellido," ",segundo_apellido) LIKE \'%'.$nombre.'%\'')
						->take(10)
						->select(\DB::raw('distinct persona.id, CONCAT(primer_nombre," ",segundo_nombre," ",primer_apellido," ",segundo_apellido) as value'))
						->get();
		return $personas;
	}


}
