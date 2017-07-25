<?php

namespace App\App\Entities;

class Estadio extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','direccion','imagen','longitud','latitud','estado'];

	protected $table = 'estadio';

}