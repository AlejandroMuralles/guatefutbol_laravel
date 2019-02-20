<?php

namespace App\App\Managers;

class AnuncioManager extends BaseManager
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
			'anunciante'  => 'required',
			'pantalla_app' => 'required',
            'segundos_mostrandose' => 'required',
            'minutos_espera' => 'required',
            'estado' => 'required',
		];

		return $rules;
    }
    
    function getRulesEditar()
	{

		$rules = [
			'anunciante'  => 'required',
			'pantalla_app' => 'required',
            'segundos_mostrandose' => 'required',
            'minutos_espera' => 'required',
            'estado' => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
        if($data['link'] == '') $data['link'] = null;
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

			$setImagen = is_null($this->entity->id);

			$this->entity->save();
			if(\Input::hasFile('imagen'))
			{
				$file = \Input::file('imagen');
				$fileOriginalName = $file->getClientOriginalName();
				$fileOrginalExtension = $file->getClientOriginalExtension();
				$fileName = $this->entity->id.'.'.$fileOrginalExtension;
				$url = 'imagenes/anuncios';
				$this->entity->imagen = $file->storeAs($url,$fileName,'public');
				$this->entity->save();
			}

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
    }
    
    function editar()
	{
		$rules = $this->getRulesEditar();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
		try{
			\DB::beginTransaction();
			$this->entity->fill($this->prepareData($this->data));

			$setImagen = is_null($this->entity->id);

			$this->entity->save();
			if(\Input::hasFile('imagen'))
			{
				$file = \Input::file('imagen');
				$fileOriginalName = $file->getClientOriginalName();
				$fileOrginalExtension = $file->getClientOriginalExtension();
				$fileName = $this->entity->id.'.'.$fileOrginalExtension;
				$url = 'imagenes/anuncios';
				$this->entity->imagen = $file->storeAs($url,$fileName,'public');
				$this->entity->save();
			}

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

}