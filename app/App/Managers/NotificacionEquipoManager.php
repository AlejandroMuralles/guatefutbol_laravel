<?php

namespace App\App\Managers;

class NotificacionEquipoManager extends BaseManager
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
			'user_id'  => 'required',
			'equipo_id'  => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}