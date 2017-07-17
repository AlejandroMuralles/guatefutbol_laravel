<?php

namespace App\App\Managers;

class UserManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;
	}

	function getChangePasswordRules()
	{
		$rules = [
			'password' 			 	=> 'required|confirmed',
			'password_confirmation' => 'required',
		];

		return $rules;
	}

	function getRulesUpdate()
	{
		$rules = [
			'password' 			 	=> 'confirmed',
			'tipo_usuario_id' 		=> 'required',
		];

		return $rules;
	}

	function getRules()
	{

		$rules = [
			'username' 			 	=> 'required|unique:users,username',
			'password' 			 	=> 'required|confirmed',
			'password_confirmation' => 'required',
			'tipo_usuario_id' 		=> 'required',
			'persona_id'			=> 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		if(!isset($data['activo']))
		{
			$data['activo'] = 0;
		}
		return $data;
	}

	public function save()
	{
		$rules = $this->getRules();
		$this->validate($rules);        
		$this->entity->fill($this->prepareData($this->data));
		$this->entity->primera_vez = 1;
		$this->entity->activo = 1;
		$this->entity->save();
		
		return true;
	}

	public function update()
	{
		$rules = $this->getRulesUpdate();
		$this->validate($rules);
		if($this->data['password'] != '')
		{
			$this->entity->primera_vez = 1;
		}
		$this->entity->fill($this->prepareData($this->data));
		$this->entity->save();
		return true;
	}

	public function cambiarPassword()
	{
		$rules = $this->getChangePasswordRules();
		$this->validate($rules); 
		$this->entity->fill($this->data);
		$this->entity->primera_vez = 0;
		
		$this->entity->save();
		
		return true;
	}

	public function validate($rules)
	{
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
	}

}