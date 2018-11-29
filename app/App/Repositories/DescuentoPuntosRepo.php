<?php

namespace App\App\Repositories;

use App\App\Entities\DescuentoPuntos;

class DescuentoPuntosRepo extends BaseRepo{

	public function getModel()
	{
		return new DescuentoPuntos;
	}

	public function getByCampeonatoByEquipo($campeonatoId, $equipoId)
	{
		return DescuentoPuntos::where('campeonato_id',$campeonatoId)->where('equipo_id',$equipoId)->get();
	}

	public function getByCampeonato($campeonatoId)
	{
		return DescuentoPuntos::where('campeonato_id',$campeonatoId)->get();
	}

	public function getByCampeonatoByTipos($campeonatoId, $tipos)
	{
		return DescuentoPuntos::where('campeonato_id',$campeonatoId)->whereIn('tipo',$tipos)->get();
	}

	public function getByLiga($ligaId)
	{
		return DescuentoPuntos::whereHas('campeonato', function($q) use ($ligaId){
									$q->where('liga_id',$ligaId);
								})->get();
	}

}