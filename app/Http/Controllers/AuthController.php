<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, Auth, View, Session;

class AuthController extends BaseController {

	public function __construct()
	{

	}

	public function mostrarLogin()
	{
		return view('publico/login');
	}

	public function login()
	{
		$data = Input::only('username','password','remember_token');

		$credentials = [
			'username' => $data['username'],
			'password' => $data['password']
		];

		if(Auth::attempt($credentials))
		{
			$user = Auth::user();
			if($user->estado == 'I')
			{
				Session::flash('error','El usuario esta inactivo. Comuniquese con su administrador.');
				return Redirect::back();
			}
			return Redirect::route('administracion');
		}

		Session::flash('error','Credenciales no válidas');
		return Redirect::back();
	}

	public function mostrarAdminDashboard()
	{
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
		return view('administracion/dashboard');
	}

	public function mostrarDashboard()
	{
		return Redirect::route('posiciones',[21,0]);
	}

	public function info()
	{
		$data['post_max_size'] = ini_get('post_max_size');
		$data['memory_limit'] = ini_get('memory_limit');
		$data['WP_MEMORY_LIMIT'] = ini_get('WP_MEMORY_LIMIT');
		dd($data);
	}

	public function logout()
	{
		$loginUser = Auth::user();
        $loginUser->facebook_user = null;
        //$loginUser->save();
		Auth::logout();
		return Redirect::route('login');
	}

}
