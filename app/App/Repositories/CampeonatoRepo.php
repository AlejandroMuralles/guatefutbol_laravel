<?php

namespace App\App\Repositories;

use App\App\Entities\Campeonato;

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
							->orderBy('liga_id')
							->orderBy('fecha_inicio','ASC')
							->get();
	}

}