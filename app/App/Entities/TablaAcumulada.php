<?php

namespace App\App\Entities;

class TablaACumulada extends \Eloquent {

	use UserStamps;

	protected $fillable = ['campeonato1_id','campeonato2_id','estado'];

	protected $table = 'tabla_acumulada';

	public function campeonato1()
	{
		return $this->belongsTo(Campeonato::class,'campeonato1_id');
	}

	public function campeonato2()
	{
		return $this->belongsTo(Campeonato::class,'campeonato2_id');
	}

}