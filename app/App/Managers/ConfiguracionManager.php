<?php

namespace App\App\Managers;

class ConfiguracionManager extends BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;
	}

	function getRules()
	{

		$rules = [
			'nombre'  	 => 'required',
			'parametro1' => 'required',
			'parametro2' => 'required',
			'parametro3' => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}