<?php

namespace App\App\Managers;
use OneSignal;

class NotificacionManager extends BaseManager
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
			'mensaje'  => 'required',
            'tipo'  => 'required',
            'cantidad_usuarios'  => 'required',
            'data'  => 'required',
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function saveArticulo($usuarios)
	{
		$this->isValid();
		try{
			$this->entity->fill($this->prepareData($this->data));
			$this->entity->estado = 'A';
			$this->entity->save();

			$data['tipo'] = 'link';
			$data['link'] = $this->data['link'];

			$response = $this->sendNotificationCustom($usuarios, $this->entity->mensaje, $data);
			if(!$response['result'])
			{
				$this->entity->estado = 'I';
				$this->entity->save();
			}

			return $this->entity;
		}
		catch(\Exception $ex)
		{
            dd($ex);
            throw new SaveDataException("Error: ", $ex);
		}
	}

	function saveTablaPosiciones($usuarios)
	{
		$this->isValid();
		try{
			$this->entity->fill($this->prepareData($this->data));
			$this->entity->estado = 'A';
			$this->entity->save();

			$data['tipo'] = 'tabla_posiciones';
			$data['liga'] = $this->data['liga'];

			$response = $this->sendNotificationCustom($usuarios, $this->entity->mensaje, $data);
			if(!$response['result'])
			{
				$this->entity->estado = 'I';
				$this->entity->save();
			}

			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error: ", $ex);
		}
	}

	function saveCalendario($usuarios)
	{
		$this->isValid();
		try{
			$this->entity->fill($this->prepareData($this->data));
			$this->entity->estado = 'A';
			$this->entity->save();

			$data['tipo'] = 'calendario';
			$data['liga'] = $this->data['liga'];

			$response = $this->sendNotificationCustom($usuarios, $this->entity->mensaje, $data);
			if(!$response['result'])
			{
				$this->entity->estado = 'I';
				$this->entity->save();
			}

			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error: ", $ex);
		}
	}

	private function sendNotificationCustom($usuarios, $mensaje, $data)
	{
		$data = array(
			'include_player_ids' => $usuarios,
			//'large_icon' => 'https://futsal502.puzzlesoft.net/assets/imagenes/logos/logo_sm.png',
			'contents' => array('en' => $mensaje),
			'data' => $data,
		);

		try{
			OneSignal::sendNotificationCustom($data);
			return ['result'=>true];
		}
		catch(\Exception $ex)
		{
            dd($ex);
			return ['result'=> false,'error'=>$ex->getMessage()];
		}
	}

}
