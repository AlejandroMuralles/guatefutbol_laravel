<?php

namespace App\App\Managers;

use App\App\Entities\TablaAcumuladaLigaDetalle;
use Exception;
use Illuminate\Support\Facades\DB;

class TablaAcumuladaLigaManager extends BaseManager
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
			'liga_id'  => 'required',
			'descripcion' => 'required',
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregar()
	{
		try{
			DB::beginTransaction();

				$this->isValid();
				$this->entity->fill($this->prepareData($this->data));		
				$this->entity->save();
				foreach($this->data['campeonatos'] as $campeonato)
				{
					$det = new TablaAcumuladaLigaDetalle();
					$det->tabla_acumulada_liga_id = $this->entity->id;
					$det->campeonato_id = $campeonato['id'];
					$det->estado = 'A';
					$det->save();
				}

			DB::commit();
		}
		catch(Exception $ex)
		{
			DB::rollback();
			throw new SaveDataException('Error!', $ex);
		}
	}

}