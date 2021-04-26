<?php

namespace App\App\Managers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EquipoManager extends BaseManager
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
			'nombre_corto' => 'required',
			'siglas' => 'required'
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
			DB::beginTransaction();
			$this->entity->fill($this->prepareData($this->data));

			$setLogo = is_null($this->entity->id);

			$this->entity->save();
			if(request()->hasFile('logo'))
			{
				$file = request()->file('logo');
				$fileOriginalName = $file->getClientOriginalName();
				$fileOrginalExtension = $file->getClientOriginalExtension();
				$fileName = Str::uuid().'.'.$fileOrginalExtension;
				$url = 'imagenes/equipos';
				$this->entity->logo = $file->storeAs($url,$fileName,env('DISK'));
				$this->entity->save();
			}
			else
			{
				if($setLogo){
					$this->entity->logo = 'imagenes/equipos/equipo.png';
					$this->entity->save();
				}
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