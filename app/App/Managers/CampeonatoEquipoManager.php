<?php

namespace App\App\Managers;

use App\App\Entities\CampeonatoEquipo;
use App\App\Entities\Plantilla;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\PlantillaRepo;

class CampeonatoEquipoManager extends BaseManager
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

	public function agregarEquipos($campeonatoId)
	{
		\DB::beginTransaction();

			$equipos = $this->data['equipos'];
	        foreach($equipos as $equipo)
	        {
	        	if(isset($equipo['seleccionado']))
	        	{
	        		$ec = new CampeonatoEquipo();
	        		$ec->campeonato_id = $campeonatoId;
	        		$ec->equipo_id = $equipo['id'];
	        		$ec->estado = 'A';
	        		$ec->save();
	        	}
	        }
	        
        \DB::commit();
	}

	public function eliminarEquipos()
	{
		\DB::beginTransaction();

			$equipos = $this->data['equipos'];
	        foreach($equipos as $equipo)
	        {
	        	if(isset($equipo['seleccionado']))
	        	{
	        		$ec = CampeonatoEquipo::find($equipo['id'])->delete();
	        	}
	        }
	        
        \DB::commit();
	}

	public function trasladarEquipos($campeonatoNuevo, $campeonatoAntiguo)
	{
		try{
			\DB::beginTransaction();

				$campeonatoEquipoRepo = new CampeonatoEquipoRepo();
				$plantillaRepo = new PlantillaRepo();

				$equipos = $this->data['equipos'];
		        foreach($equipos as $equipo)
		        {
		        	if(isset($equipo['seleccionado']))
		        	{
		        		$e = $campeonatoEquipoRepo->getEquipoInCampeonato($campeonatoNuevo, $equipo['id']);
		        		if(is_null($e)){			        		
		        			$ec = new CampeonatoEquipo();
			        		$ec->campeonato_id = $campeonatoNuevo;
			        		$ec->equipo_id = $equipo['id'];
			        		$ec->estado = 'A';
			        		$ec->save();
			        	}
			        	else{
			        		$ec = $e;
			        	}

			        	if(isset($this->data['incluir_personas'])){
			        		
							$personas = $plantillaRepo->getPersonas($campeonatoNuevo, $equipo['id']);
							foreach($personas as $persona){
								$persona->delete();
							}
							$personas = $plantillaRepo->getPersonas($campeonatoAntiguo, $equipo['id']);
							foreach($personas as $persona){
								$p = new Plantilla();
				        		$p->campeonato_id = $campeonatoNuevo;
				        		$p->equipo_id = $equipo['id'];
				        		$p->persona_id = $persona->persona_id;
				        		$p->estado = 'A';
				        		$p->save();
							}
			        	}

		        	}
		        }
		        
	        \DB::commit();
	    }
	    catch(\Exception $ex)
	    {
	    	throw new SaveDataException('Error',$ex);
	    }
	}

}