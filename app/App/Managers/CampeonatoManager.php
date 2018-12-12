<?php

namespace App\App\Managers;

class CampeonatoManager extends BaseManager
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
			'liga_id' => 'required',
			'fecha_inicio' => 'required|date',
			'fecha_fin' => 'required|date',
			'hashtag' => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		$data['grupos'] = isset($data['grupos']) ? 1 : 0;
		$data['actual'] = isset($data['actual']) ? 1 : 0;
        $data['mostrar_app'] = isset($data['mostrar_app']) ? 1 : 0;
        $data['menu_app_calendario'] = isset($data['menu_app_calendario']) ? 1 : 0;
        $data['menu_app_posiciones'] = isset($data['menu_app_posiciones']) ? 1 : 0;
        $data['menu_app_tala_acumulada'] = isset($data['menu_app_tala_acumulada']) ? 1 : 0;
        $data['menu_app_goleadores'] = isset($data['menu_app_goleadores']) ? 1 : 0;
        $data['menu_app_porteros'] = isset($data['menu_app_porteros']) ? 1 : 0;
        $data['menu_app_plantilla'] = isset($data['menu_app_plantilla']) ? 1 : 0;
		return $data;
	}

}
