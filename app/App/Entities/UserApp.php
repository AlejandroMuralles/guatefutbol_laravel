<?php

namespace App\App\Entities;

class UserApp extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['uuid','fabricante','modelo','plataforma'];

	protected $table = 'users_app';

}