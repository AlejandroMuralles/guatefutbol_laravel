<?php

namespace App\App\Managers;

class AnuncioManager extends BaseManager
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
			'nombre'  => 'required',
			'ruta'  => 'required',
			'tipo'  => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}