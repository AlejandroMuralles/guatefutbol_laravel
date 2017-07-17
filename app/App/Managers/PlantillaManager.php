<?php

namespace App\App\Managers;

use App\App\Entities\Plantilla;

class PlantillaManager extends BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;
	}

	public function getRules()
	{

	}

	public function agregarPersonas($campeonatoId, $equipoId)
	{
		\DB::beginTransaction();

			$personas = $this->data['personas'];
	        foreach($personas as $persona)
	        {
	        	if(isset($persona['seleccionado']))
	        	{
	        		$ecp = new Plantilla();
	        		$ecp->campeonato_id = $campeonatoId;
	        		$ecp->equipo_id = $equipoId;
	        		$ecp->persona_id = $persona['id'];
	        		$ecp->estado = 'A';
	        		$ecp->save();
	        	}
	        }
	        
        \DB::commit();
	}

	public function eliminarPersonas()
	{
		\DB::beginTransaction();

			$personas = $this->data['personas'];
	        foreach($personas as $persona)
	        {
	        	if(isset($persona['seleccionado']))
	        	{
	        		$ec = Plantilla::find($persona['id'])->delete();
	        	}
	        }
	        
        \DB::commit();
	}

}