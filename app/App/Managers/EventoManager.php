<?php

namespace App\App\Managers;

class EventoManager extends BaseManager
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
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function save()
	{
		$rules = $this->getRules();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
		try{
			\DB::beginTransaction();
			$this->entity->fill($this->prepareData($this->data));
			$this->entity->save();
			if(\Input::hasFile('imagen'))
			{
				$file = \Input::file('imagen');
				$fileOriginalName = $file->getClientOriginalName();
				$fileOrginalExtension = $file->getClientOriginalExtension();
				$fileName = $this->entity->id.'.'.$fileOrginalExtension;
				$url = 'imagenes/eventos';
				$this->entity->imagen = $file->storeAs($url,$fileName,'public');
				$this->entity->save();
			}
			else
			{
				$this->entity->imagen = 'imagenes/eventos/nada.png';
				$this->entity->save();
			}

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			dd($ex);
			throw new SaveDataException("Error!", $ex);			
		}
	}

}