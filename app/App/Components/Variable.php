<?php 

namespace App\App\Components;

use Illuminate\Support\Facades\Facade;

class Variable extends Facade {

	protected static function getFacadeAccessor() { return 'variable'; }

}