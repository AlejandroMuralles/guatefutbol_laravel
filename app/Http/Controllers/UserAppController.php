<?php

namespace App\Http\Controllers;

use App\App\Repositories\UserAppRepo;
use App\App\Managers\UserAppManager;
use App\App\Entities\UserApp;
use Controller, Redirect, Input, View, Session;

class UserAppController extends BaseController {

	protected $userAppRepo;

	public function __construct(UserAppRepo $userAppRepo)
	{
		$this->userAppRepo = $userAppRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$users = $this->userAppRepo->all('created_at');
		return view('administracion/UsersApp/listado', compact('users'));
	}

	public function registrar()
	{
        $data = Input::all();
        $data['ultima_sesion'] = date('Y-m-d H:i:s');
        $data['notificaciones'] = 1;
        $user = $this->userAppRepo->getByUUID($data['uuid']);
        if($user){
            $user->ultima_sesion = date('Y-m-d H:i:s');
            $user->save();
            $u = new UserApp();
            $u->id = $user->id;
            $u->uuid = $user->uuid;
            $u->one_signal_id = $user->one_signal_id;
            $u->notificaciones = $user->notificaciones;
            return ['resultado' => true, 'mensaje' => 'Ya existe el usuario. Se obtuvo el usuario.', 'user' => $u];
        }
		$manager = new UserAppManager(new UserApp(), $data);
        $result = $manager->save();
		return json_encode($result);
    }
    
    public function activarNotificaciones()
    {
        $data = Input::all();
        $user = $this->userAppRepo->find($data['user_app_id']);
        if($user){
            $manager = new UserAppManager($user, $data);
            $result = $manager->activarNotificaciones();
        }
		return json_encode($result);
    }

    public function desactivarNotificaciones()
    {
        $data = Input::all();
        $user = $this->userAppRepo->find($data['user_app_id']);
        if($user){
            $manager = new UserAppManager($user, $data);
            $result = $manager->desactivarNotificaciones();
        }
		return json_encode($result);
    }

}