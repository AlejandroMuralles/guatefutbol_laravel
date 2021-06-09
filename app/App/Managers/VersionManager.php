<?php

namespace App\App\Managers;

class VersionManager extends BaseManager
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
			'android'  => 'required',
			'ios'  => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}