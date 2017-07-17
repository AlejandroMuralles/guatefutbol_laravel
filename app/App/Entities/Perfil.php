<?php

namespace App\App\Entities;

class Perfil extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['nombre','estado'];

	protected $table = 'perfil';

}