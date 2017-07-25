<?php

namespace App\App\Components;

use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->singleton('field', function($app)
		{
			$fieldBuilder = new FieldBuilder($app['form'], $app['view'], $app['session.store']);
			return $fieldBuilder;
		});
		$this->app->alias('field', 'App\App\Components\FieldBuilder');
	}

}