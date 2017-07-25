<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, Auth, View;

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
			return Redirect::route('administracion');
		}
		
		return Redirect::back()->with('login-error',1);
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

	public function logout()
	{
		$loginUser = Auth::user();
        $loginUser->facebook_user = null;
        //$loginUser->save();
		Auth::logout();
		return Redirect::route('login');
	}

}