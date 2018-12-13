<?php

namespace App\App\Repositories;

use App\App\Entities\Liga;

class LigaRepo extends BaseRepo{

	public function getModel()
	{
		return new Liga;
	}

	public function getByEstado($estados)
	{
		return Liga::whereIn('estado',$estados)->orderBy('orden','ASC')->orderBy('nombre')->get();
    }
    
    public function getByNotificaciones($notificaciones)
	{
		return Liga::whereIn('notificaciones',$notificaciones)->orderBy('orden','ASC')->orderBy('nombre')->get();
    }
    
    public function getByNotificacionesByMostrarAppByEstado($notificaciones,$mostrarApp,$estados)
	{
        return Liga::whereIn('notificaciones',$notificaciones)
                    ->whereIn('mostrar_app',$mostrarApp)
                    ->whereIn('estado',$estados)
                    ->orderBy('orden','ASC')->orderBy('nombre')->get();
	}

}