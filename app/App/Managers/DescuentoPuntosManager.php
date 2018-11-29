<?php

namespace App\App\Managers;

class DescuentoPuntosManager extends BaseManager
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
			'campeonato_id'  => 'required',
			'equipo_id'  => 'required',
			'puntos'  => 'required',
			'tipo'  => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}