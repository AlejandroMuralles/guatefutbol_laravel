<?php

namespace App\App\Repositories;

use App\App\Entities\TablaAcumuladaLigaDetalle;

class TablaAcumuladaLigaDetalleRepo extends BaseRepo{

	public function getModel()
	{
		return new TablaAcumuladaLigaDetalle;
	}

	public function getByTablaAcumuladaLiga($tablaAcumuladaLigaId)
	{
		return TablaAcumuladaLigaDetalle::where('tabla_acumulada_liga_id',$tablaAcumuladaLigaId)->get();
	}

	public function getByCampeonato($campeonatoId)
	{
		return TablaAcumuladaLigaDetalle::where('campeonato_id',$campeonatoId)->first();
	}

}