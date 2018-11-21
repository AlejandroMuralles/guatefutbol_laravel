<?php

namespace App\App\Repositories;

use App\App\Entities\VwEstadisticaJugadorCampeonato;

class VwEstadisticaJugadorCampeonatoRepo extends BaseRepo{

	public function getModel()
	{
		return new VwEstadisticaJugadorCampeonato;
	}

	public function getByCampeonato($campeonatoId)
	{
		return VwEstadisticaJugadorCampeonato::where('campeonato_id',$campeonatoId)
										->orderBy('primer_nombre')
										->orderBy('segundo_nombre')
										->orderBy('primer_apellido')
										->orderBy('segundo_apellido')->get();
	}

}