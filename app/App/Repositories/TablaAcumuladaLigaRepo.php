<?php

namespace App\App\Repositories;

use App\App\Entities\TablaAcumuladaLiga;

class TablaAcumuladaLigaRepo extends BaseRepo{

	public function getModel()
	{
		return new TablaAcumuladaLiga;
	}

	public function getByLiga($ligaId)
	{
		return TablaAcumuladaLiga::where('liga_id',$ligaId)->get();
	}

}