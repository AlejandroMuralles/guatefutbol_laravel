<?php

namespace App\App\Entities;

class Notificacion extends \Eloquent {

	use UserStamps;

	protected $fillable = ['mensaje','tipo','cantidad_usuarios','data','estado'];

	protected $table = 'notificacion';

}
