<?php

namespace App\App\Entities;

class TablaAcumuladaLiga extends \Eloquent {

	use UserStamps;

	protected $fillable = ['liga_id','descripcion','estado'];

	protected $table = 'tabla_acumulada_liga';

	public function liga()
	{
		return $this->belongsTo(Liga::class);
	}

}