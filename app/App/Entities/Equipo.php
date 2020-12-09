<?php

namespace App\App\Entities;

class Equipo extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','nombre_corto','siglas','logo','estado'];

	protected $table = 'equipo';

	public function getLogoAttribute($logo)
    {
    	if(!is_null($logo))
    		return \Storage::disk('spaces')->url($logo);
    	return null;
    }

}