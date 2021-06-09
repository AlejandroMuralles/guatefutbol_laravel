<?php

namespace App\App\Managers;

class CampeonatoExternoManager extends BaseManager
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
			'nombre_liga'  => 'required',
			'nombre'  => 'required',
			'link' => 'required',
			'estado' => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}
