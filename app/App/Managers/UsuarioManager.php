<?php

namespace App\App\Managers;

class UsuarioManager extends BaseManager
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
			'username' 			 	=> 'required|unique:users,username',
			'password' 			 	=> 'required|confirmed',
			'password_confirmation' => 'required',
		];

		return $rules;
	}

	function getRulesForUpdate()
	{
		$rules = [];
		if($this->data['password'] != '')
		{
			$rules['password'] = 'confirmed';
		}
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function update()
	{
		$rules = $this->getRulesForUpdate();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
		$this->entity->fill($this->prepareData($this->data));
		$this->entity->save();
		return true;
	}

}