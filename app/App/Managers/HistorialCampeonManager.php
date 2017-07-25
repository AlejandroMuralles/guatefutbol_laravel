<?php

namespace App\App\Managers;

class HistorialCampeonManager extends BaseManager
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
			'campeonato'  => 'required',
			'equipo_campeon' => 'required',
			'entrenador_campeon' => 'required',
			'equipo_subcampeon' => 'required',
			'fecha' => 'required|date',
			'veces_equipo' => 'required|integer',
			'veces_entrenador' => 'required|integer',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}