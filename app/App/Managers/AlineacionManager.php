<?php

namespace App\App\Managers;

use App\App\Entities\Alineacion;
use App\App\Repositories\AlineacionRepo;

class AlineacionManager extends BaseManager
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
			'partido_id'  => 'required',
			'equipo_id' => 'required',
			'persona_id' => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregar($partidoId, $equipoId)
	{

		try
		{
			\DB::beginTransaction();

			Alineacion::where('partido_id', '=', $partidoId)->where('equipo_id','=',$equipoId)->delete();

			if($this->data['tecnico_id'] != ''){
				$tecnico = new Alineacion();
				$tecnico->persona_id = $this->data['tecnico_id'];
				$tecnico->partido_id = $partidoId;
				$tecnico->equipo_id = $equipoId;

				$tecnico->save();
			}
			else{
				//dd('no tecnico');
			}
			

			$jugadores = $this->data['jugadores'];
			foreach($jugadores as $jugador)
			{
				if(isset($jugador['inicia']))
				{
					$j = new Alineacion();
					$j->persona_id = $jugador['id'];
					$j->partido_id = $partidoId;
					$j->equipo_id = $equipoId;
					$j->es_titular = 1;
					$j->minutos_jugados = 90;
					$j->save();
				}
				if(isset($jugador['suplente'])){
					$j = new Alineacion();
					$j->persona_id = $jugador['id'];
					$j->partido_id = $partidoId;
					$j->equipo_id = $equipoId;
					$j->es_titular = 0;
					$j->minutos_jugados = 0;
					$j->save();
				}
			}

			\DB::commit();

		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}

	}

	function editarMinutos($partidoId, $equipoId)
	{
		$alineacionRepo = new AlineacionRepo();
		try
		{
			\DB::beginTransaction();

			$jugadores = $this->data['jugadores'];
			foreach($jugadores as $jugador)
			{
				$j = $alineacionRepo->find($jugador['id']);
				$j->minutos_jugados = $jugador['minutos_jugados'];
				$j->save();
			}

			\DB::commit();

		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}
	}

}