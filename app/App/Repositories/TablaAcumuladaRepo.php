<?php

namespace App\App\Repositories;

use App\App\Entities\TablaAcumulada;

class TablaAcumuladaRepo extends BaseRepo{

	public function getModel()
	{
		return new TablaAcumulada;
	}

	public function getByLiga($ligaId)
	{
		return TablaAcumulada::whereHas('campeonato1',function($q) use ($ligaId){
				$q->where('liga_id',$ligaId);
		})->get();
	}

	public function getByCampeonato($campeonatoId)
	{
		return TablaAcumulada::where('campeonato1_id','=',$campeonatoId)->orWhere('campeonato2_id','=',$campeonatoId)->get();
	}

}