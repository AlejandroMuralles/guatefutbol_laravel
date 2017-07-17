<?php

namespace App\App\Managers;

class LigaManager extends BaseManager
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
		];

		return $rules;
	}

	function prepareData($data)
	{
		$data['mostrar_app'] = isset($data['mostrar_app']) ? 1 : 0;
		return $data;
	}

}