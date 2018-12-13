<?php

namespace App\Http\Controllers;

use App\App\Repositories\NotificacionEquipoRepo;
use App\App\Managers\NotificacionEquipoManager;
use App\App\Entities\NotificacionEquipo;
use Controller, Redirect, Input, View, Session,Variable;

use App\App\Repositories\LigaRepo;
use App\App\Repositories\UserAppRepo;

class NotificacionesController extends BaseController {

    protected $ligaRepo;
    protected $notificacionEquipoRepo;
    protected $userAppRepo;

    public function __construct(LigaRepo $ligaRepo, NotificacionEquipoRepo $notificacionEquipoRepo,
                                    UserAppRepo $userAppRepo)
	{
        $this->ligaRepo = $ligaRepo;
        $this->notificacionEquipoRepo = $notificacionEquipoRepo;
        $this->userAppRepo = $userAppRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function ligas()
	{
		$ligas = $this->ligaRepo->getByNotificacionesByMostrarAppByEstado([1],[1],['A']);
		return ['ligas' => $ligas];
    }
    
    public function equiposPorUser($userId, $ligaId)
	{
        $equipos = $this->notificacionEquipoRepo->getEquiposByUser($userId, $ligaId);
		usort($equipos,function($a,$b){
			return strcmp($a['nombre'],$b['nombre']);
		});
		return json_encode(['equipos'=>$equipos]);
    }
    
    public function agregarEquipoUser(){
		$userId = \Input::get('user_app_id');
		$equipoId = \Input::get('equipo_id');

		$usuario = $this->userAppRepo->find($userId);
		try{
			if(is_null($usuario))
			{
				$data['resultado'] = false;
				$data['mensaje'] = 'No se pudieron activar las notificaciones. Usuario no existe.';
				return json_encode($data);
			}
			else
			{
				$ne = new NotificacionEquipo();
				$ne->user_app_id = $usuario->id;
				$ne->equipo_id = $equipoId;
				$ne->save();
			}
			$data['resultado'] = true;
			$data['mensaje'] = 'Se activaron las notificaciones';
			return json_encode($data);
		}
		catch(\Exception $ex)
		{
			$data['resultado'] = false;
			$data['mensaje'] = 'No se pudieron activar las notificaciones.' . $ex->getMessage();
			return json_encode($data);
		}
	}

	public function eliminarEquipoUser(){
		$userId = \Input::get('user_app_id');
		$equipoId = \Input::get('equipo_id');

		$usuario = $this->userAppRepo->find($userId);
		try{
			if(is_null($usuario))
			{
				$data['resultado'] = false;
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
					$data['resultado'] = false;
					$data['mensaje'] = 'No se pudieron remover las notificaciones. Equipo y Usuario no existe.';
					return json_encode($data);
				}
				
			}
			$data['resultado'] = true;
			$data['mensaje'] = 'Se removieron las notificaciones';
			return json_encode($data);
		}
		catch(\Exception $ex)
		{
			$data['resultado'] = false;
			$data['mensaje'] = 'No se pudieron remover las notificaciones. Error: ' . $ex;
			return json_encode($data);
		}
	}


}