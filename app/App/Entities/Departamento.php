<?php

namespace App\App\Entities;

class Departamento extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','pais_id','estado'];

	protected $table = 'departamento';

	public function pais()
	{
		return $this->belongsTo(Pais::class);
	}

}