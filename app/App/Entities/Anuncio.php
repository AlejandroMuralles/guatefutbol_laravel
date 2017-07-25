<?php

namespace App\App\Entities;

class Anuncio extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['nombre','ruta','tipo'];

	protected $table = 'anuncio';

	use UserStamps;

}