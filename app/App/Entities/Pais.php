<?php

namespace App\App\Entities;

class Pais extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','estado'];

	protected $table = 'pais';

}