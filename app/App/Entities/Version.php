<?php

namespace App\App\Entities;

class Version extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['android','ios'];

	protected $table = 'version';

}