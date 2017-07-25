<?php

namespace App\App\Managers;

use App\App\Entities\Permiso;

class PermisoManager 
{
	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;
	}

	public function save()
	{
		\DB::beginTransaction();
	 	try{

	 		Permiso::where('perfil_id', '=', $this->entity->id)->delete();

			foreach($this->data['vistas'] as $vista){
				$permiso = new Permiso();
				$permiso->perfil_id = $this->entity->id;
				$permiso->vista_id = $vista['id'];
				$permiso->save();
			}
			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}
		return true;
	}

}