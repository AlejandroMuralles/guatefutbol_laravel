<?php

namespace App\Http\Controllers;

use App\App\Repositories\NotificacionUsuarioRepo;
use App\App\Repositories\NotificacionEquipoRepo;
use App\App\Managers\NotificacionUsuarioManager;
use App\App\Managers\NotificacionEquipoManager;
use App\App\Entities\NotificacionUsuario;
use App\App\Entities\NotificacionEquipo;
use Controller, Redirect, Input, View, Session;

class MobileController extends BaseController {

	protected $notificacionEquipoRepo;
	protected $notificacionUsuarioRepo;

	public function __construct(NotificacionEquipoRepo $notificacionEquipoRepo, 
								NotificacionUsuarioRepo $notificacionUsuarioRepo)
	{
		$this->notificacionEquipoRepo = $notificacionEquipoRepo;
		$this->notificacionUsuarioRepo = $notificacionUsuarioRepo;
	}

	public function notificacionesActivas($user)
	{
		$usuario = $this->notificacionUsuarioRepo->getByUser($user);
		if(is_null($usuario))
		{
			return json_encode(['activo'=>'false']);
		}
		return json_encode(['activo'=>'true']);
	}

	public function notificacionesEquipos($user, $ligaId)
	{
		$usuario = $this->notificacionUsuarioRepo->getByUser($user);
		$equipos = [];
		if(!is_null($usuario))
		{
			$equipos = $this->notificacionEquipoRepo->getEquiposByUser($usuario->id, $ligaId);
		}
		usort($equipos,function($a,$b){
			return strcmp($a['nombre'],$b['nombre']);
		});
		return json_encode(['equipos'=>$equipos]);
	}

	public function removeUser()
	{
		$user = \Input::get('user');

		$usuario = $this->notificacionUsuarioRepo->getByUser($user);
		try{
			if(!is_null($usuario))
			{
				$equipos = $this->notificacionEquipoRepo->getByUser($usuario->id);
				if(count($equipos)>0){
					foreach($equipos as $equipo){
						$equipo->delete();
					}
				}
				$usuario->delete();
			}
			else{
				$data['error'] = false;
				$data['mensaje'] = 'No se pudieron desactivar las notificaciones. Usuario no existe.';
				return json_encode($data);
			}
			$data['error'] = false;
			$data['mensaje'] = 'Se desactivaron todas las notificaciones';
			return json_encode($data);
		}
		catch(\Exception $ex)
		{
			$data['error'] = true;
			$data['mensaje'] = 'No se pudieron desactivar las notificaciones. Error: '.$ex;
			return json_encode($data);
		}
	}

	public function addUser()
	{
		$user = \Input::get('user');
		$token = \Input::get('token');

		$usuario = $this->notificacionUsuarioRepo->getByUser($user);
		try{
			if(is_null($usuario))
			{
				$nu = new NotificacionUsuario();
				$nu->user = $user;
				$nu->token = $token;
				$nu->save();
			}
			else
			{
				$usuario->token = $token;
				$usuario->save();
			}
			$data['error'] = false;
			$data['mensaje'] = 'Se activaron las notificaciones';
			return json_encode($data);
		}
		catch(\Exception $ex)
		{
			$data['error'] = true;
			$data['mensaje'] = 'No se pudieron activar las notificaciones';
			return json_encode($data);
		}
	}

	public function addEquipoUser(){
		$user = \Input::get('user');
		$equipoId = \Input::get('equipoId');

		$usuario = $this->notificacionUsuarioRepo->getByUser($user);
		try{
			if(is_null($usuario))
			{
				$data['error'] = true;
				$data['mensaje'] = 'No se pudieron activar las notificaciones. Usuario no existe.';
				return json_encode($data);
			}
			else
			{
				$ne = new NotificacionEquipo();
				$ne->user_id = $usuario->id;
				$ne->equipo_id = $equipoId;
				$ne->save();
			}
			$data['error'] = false;
			$data['mensaje'] = 'Se activaron las notificaciones';
			return json_encode($data);
		}
		catch(\Exception $ex)
		{
			$data['error'] = true;
			$data['mensaje'] = 'No se pudieron activar las notificaciones. Error: ' . $ex;
			return json_encode($data);
		}
	}

	public function removeEquipoUser(){
		$user = \Input::get('user');
		$equipoId = \Input::get('equipoId');

		$usuario = $this->notificacionUsuarioRepo->getByUser($user);
		try{
			if(is_null($usuario))
			{
				$data['error'] = true;
				$data['mensaje'] = 'No se pudieron remover las notificaciones. Usuario no existe.';
				return json_encode($data);
			}
			else
			{
				$equipos = $this->notificacionEquipoRepo->getByUserByEquipo($usuario->id, $equipoId);
				if(count($equipos)>0){
					foreach($equipos as $equipo){
						$equipo->delete();
					}
				}
				else{
					$data['error'] = true;
					$data['mensaje'] = 'No se pudieron remover las notificaciones. Equipo y Usuario no existe.';
					return json_encode($data);
				}
				
			}
			$data['error'] = false;
			$data['mensaje'] = 'Se removieron las notificaciones';
			return json_encode($data);
		}
		catch(\Exception $ex)
		{
			$data['error'] = true;
			$data['mensaje'] = 'No se pudieron remover las notificaciones. Error: ' . $ex;
			return json_encode($data);
		}
	}


}