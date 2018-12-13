<?php

namespace App\App\Managers;
use App\App\Entities\UserApp;

class UserAppManager extends BaseManager
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
			'uuid'  => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
    }
    
    function save()
    {
        //$this->isValid();
        $this->entity->fill($this->prepareData($this->data));
        try{
            $this->entity->save();
            $u = new UserApp();
            $u->id = $this->entity->id;
            $u->uuid = $this->entity->uuid;
		    return ['resultado' => true, 'mensaje' => 'Se creó el usuario.', 'user' => $u];
        }
        catch(\Exception $ex)
        {
            return ['resultado' => false, 'mensaje' => 'No se pudo crear el usuario.', 'excepcion' => $ex->getMessage()];
        }
		
    }

}