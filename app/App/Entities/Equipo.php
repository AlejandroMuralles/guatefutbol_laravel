<?php

namespace App\App\Entities;

class Equipo extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','nombre_corto','siglas','logo','estado'];

	protected $table = 'equipo';

	public function getLogoAttribute($logo)
    {
		return asset("assets/$logo");
    	if(!is_null($logo))
    		return \Storage::disk('public')->url($logo);
    	return null;
    }

}