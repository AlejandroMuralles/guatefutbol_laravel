<?php

namespace App\App\Managers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

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
			DB::beginTransaction();
			$this->entity->fill($this->prepareData($this->data));

			$setImagen = is_null($this->entity->id);

			$this->entity->save();
			if(Input::hasFile('imagen'))
			{
				$file = Input::file('imagen');
				$fileOriginalName = $file->getClientOriginalName();
				$fileOrginalExtension = $file->getClientOriginalExtension();
				$fileName = uniqid().'.'.$fileOrginalExtension;
				$url = 'imagenes/anuncios';
				$this->entity->imagen = $file->storeAs($url,$fileName,env('DISK'));
				$this->entity->save();
			}

			DB::commit();
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
			DB::beginTransaction();
			$this->entity->fill($this->prepareData($this->data));

			$this->entity->save();
			if(Input::hasFile('imagen'))
			{
				Storage::disk(env('DISK'))->delete($this->entity->imagen);
				$file = Input::file('imagen');
				$fileOriginalName = $file->getClientOriginalName();
				$fileOrginalExtension = $file->getClientOriginalExtension();
				$fileName = uniqid().'.'.$fileOrginalExtension;
				$url = 'imagenes/anuncios';
				$this->entity->imagen = $file->storeAs($url,$fileName,env('DISK'));
				$this->entity->save();
			}

			DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

}