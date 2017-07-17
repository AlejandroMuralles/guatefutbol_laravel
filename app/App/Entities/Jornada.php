<?php

namespace App\App\Entities;

class Jornada extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['nombre','fase','numero','estado'];

	protected $table = 'jornada';

}