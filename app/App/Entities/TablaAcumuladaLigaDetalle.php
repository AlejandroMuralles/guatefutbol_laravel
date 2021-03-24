<?php

namespace App\App\Entities;

class TablaAcumuladaLigaDetalle extends \Eloquent {

	use UserStamps;

	protected $fillable = ['tabla_acumulada_liga_id','campeonato_id','estado'];

	protected $table = 'tabla_acumulada_liga_detalle';

	public function campeonato()
	{
		return $this->belongsTo(Campeonato::class);
	}

}