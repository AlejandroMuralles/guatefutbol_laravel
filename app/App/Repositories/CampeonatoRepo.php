<?php

namespace App\App\Repositories;

use App\App\Entities\Campeonato;
use App\App\Entities\TablaAcumuladaLiga;
use App\App\Entities\TablaAcumuladaLigaDetalle;

class CampeonatoRepo extends BaseRepo{

	public function getModel()
	{
		return new Campeonato;
	}

	public function getByLiga($ligaId)
	{
		return Campeonato::where('liga_id',$ligaId)
							->orderBy('fecha_inicio','DESC')
							->get();
	}

	public function getByLigaNotInTablaAcumuladaLiga($ligaId)
	{
		$campeonatosIds = TablaAcumuladaLigaDetalle::pluck('campeonato_id');
		return Campeonato::where('liga_id',$ligaId)
							->whereNotIn('id',$campeonatosIds)
							->orderBy('fecha_inicio','DESC')
							->get();
	}

	public function getActual($ligaId)
	{	
		$campeonato = Campeonato::where('liga_id',$ligaId)
			->where('actual',1)
			->get();
		if(count($campeonato) == 0)
		{
			$campeonato = $this->getByLiga($ligaId);
			return $campeonato[0];
		}
		return $campeonato[0];
	}

	public function getByEstado($ligaId, $estados)
	{
		return Campeonato::where('liga_id','=',$ligaId)
							->whereIn('estado',$estados)
							->orderBy('fecha_inicio','DESC')
							->get();
	}

	public function getMostrarApp()
	{
		return Campeonato::where('mostrar_app',1)
							->whereHas('liga',function($q){
								$q->where('mostrar_app',1);
							})
							->orderBy('liga_id')
							->orderBy('fecha_inicio','ASC')
							->orderBy('nombre','ASC')
							->get();
	}

}