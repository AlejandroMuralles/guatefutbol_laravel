<?php

namespace App\App\Components;

use Illuminate\Support\ServiceProvider;

class VariableServiceProvider extends ServiceProvider {

	public function register()
	{
		\App::bind('variable', function()
		{
		    return new \App\App\Components\StaticVariables;
		});
	}

}