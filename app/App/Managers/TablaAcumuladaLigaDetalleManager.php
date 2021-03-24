<?php

namespace App\App\Managers;

use App\App\Entities\TablaAcumuladaLigaDetalle;
use Exception;
use Illuminate\Support\Facades\DB;

class TablaAcumuladaLigaDetalleManager extends BaseManager
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
			'tabla_acumulada_liga_id' => 'required',
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function delete()
	{
		try{
			DB::beginTransaction();

				$this->entity->delete();

			DB::commit();
		}
		catch(Exception $ex)
		{
			DB::rollback();
			throw new SaveDataException('Error!', $ex);
		}
	}

}