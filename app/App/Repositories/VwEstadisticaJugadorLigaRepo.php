<?php

namespace App\App\Repositories;

use App\App\Entities\VwEstadisticaJugadorLiga;

class VwEstadisticaJugadorLigaRepo extends BaseRepo{

	public function getModel()
	{
		return new VwEstadisticaJugadorLiga;
	}

	public function getByLiga($ligaId)
	{
		return VwEstadisticaJugadorLiga::where('liga_id',$ligaId)
										->orderBy('primer_nombre')
										->orderBy('segundo_nombre')
										->orderBy('primer_apellido')
										->orderBy('segundo_apellido')->get();
	}

}