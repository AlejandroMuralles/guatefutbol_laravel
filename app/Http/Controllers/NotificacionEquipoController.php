<?php

namespace App\Http\Controllers;

use App\App\Repositories\NotificacionEquipoRepo;
use App\App\Managers\NotificacionEquipoManager;
use App\App\Entities\NotificacionEquipo;
use Controller, Redirect, Input, View, Session,Variable;

use App\App\Entities\UserApp;

class NotificacionEquipoController extends BaseController {

    protected $notificacionEquipoRepo;

    public function __construct(NotificacionEquipoRepo $notificacionEquipoRepo)
	{
        $this->notificacionEquipoRepo = $notificacionEquipoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(UserApp $userApp)
	{
		$notificaciones = $this->notificacionEquipoRepo->getByUser($userApp->id);
		return view('administracion/NotificacionEquipo/listado', compact('notificaciones','userApp'));
    }

}