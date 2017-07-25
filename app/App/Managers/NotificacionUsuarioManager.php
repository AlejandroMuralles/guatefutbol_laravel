<?php

namespace App\App\Managers;

class NotificacionUsuarioManager extends BaseManager
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
			'user'  => 'required',
			'token' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}