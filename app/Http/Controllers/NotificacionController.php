<?php

namespace App\Http\Controllers;

use App\App\Repositories\NotificacionRepo;
use App\App\Managers\NotificacionManager;
use App\App\Entities\Notificacion;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Liga;
use App\App\Entities\Campeonato;
use App\App\Repositories\LigaRepo;
use App\App\Repositories\UserAppRepo;
use App\App\Repositories\CampeonatoRepo;

class NotificacionController extends BaseController {

	protected $notificacionRepo;
	protected $userAppRepo;
    protected $ligaRepo;
    protected $campeonatoRepo;

    public function __construct(NotificacionRepo $notificacionRepo, UserAppRepo $userAppRepo, LigaRepo $ligaRepo,
                                CampeonatoRepo $campeonatoRepo)
	{
		$this->notificacionRepo = $notificacionRepo;
		$this->userAppRepo = $userAppRepo;
        $this->ligaRepo = $ligaRepo;
        $this->campeonatoRepo = $campeonatoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$notificaciones = $this->notificacionRepo->all('created_at');
		$ligas = $this->ligaRepo->getByEstado(['A'],'descripcion');
		return view('administracion/Notificacion/listado', compact('notificaciones','ligas'));
	}

	public function mostrarAgregarArticulo()
	{
        $tipos = Variable::getTiposNotificacion();
		return view('administracion/Notificacion/agregar_articulo',compact('tipos'));
	}

	public function agregarArticulo()
	{
		$data = Input::all();
		$dataSend = $data;
		unset($dataSend['_token']);
		$data['data'] = json_encode($dataSend);

        $usuarios = $this->userAppRepo->getByNotificaciones([1])->pluck('one_signal_id')->toArray();
		$data['cantidad_usuarios'] = count($usuarios);
        $data['estado'] = 'A';
		$manager = new NotificacionManager(new Notificacion(), $data);
		$notificacion = $manager->saveArticulo($usuarios);
		Session::flash('success', 'Se agregó la notificacion de articulo con éxito.');
		return redirect()->route('notificaciones');
	}

	public function mostrarAgregarTablaPosiciones(Campeonato $campeonato)
	{
		return view('administracion/Notificacion/agregar_tabla_posiciones',compact('campeonato'));
	}

	public function agregarTablaPosiciones(Campeonato $campeonato)
	{
		$data = Input::all();
		$dataSend = $data;
		unset($dataSend['_token']);
        $data['campeonato'] = $campeonato;
		$data['data'] = json_encode($dataSend);
		$usuarios = $this->userAppRepo->getByNotificaciones([1])->pluck('one_signal_id')->toArray();
		$data['cantidad_usuarios'] = count($usuarios);
		$data['estado'] = 'A';

		$manager = new NotificacionManager(new Notificacion(), $data);
		$notificacion = $manager->saveTablaPosiciones($usuarios);
		Session::flash('success', 'Se agregó la notificacion de tabla de posiciones con éxito.');
		return redirect()->route('notificaciones');
	}

	public function mostrarAgregarCalendario(Campeonato $campeonato)
	{
        $liga = $this->ligaRepo->find($ligaId);
        if($campeonatoId == 0)
        {
            $campeonato = $this->campeonatoRepo->getActual($ligaId);
            $campeonatoId = !is_null($campeonato) ? $campeonato->id : 0;
        }
        else
        {
            $campeonato = $this->campeonatoRepo->find($campeonatoId);
        }
		return view('administracion/Notificacion/agregar_calendario',compact('liga','campeonato','ligaId','campeonatoId'));
	}

	public function agregarCalendario(Campeonato $campeonato)
	{
		$data = Input::all();
		$dataSend = $data;

		unset($dataSend['_token']);
        $data['campeonato'] = $campeonato;
		$data['data'] = json_encode($dataSend);

		$usuarios = $this->userAppRepo->getByNotificaciones([1])->pluck('one_signal_id')->toArray();
		$data['cantidad_usuarios'] = count($usuarios);
		$data['estado'] = 'A';

		$manager = new NotificacionManager(new Notificacion(), $data);
		$notificacion = $manager->saveCalendario($usuarios);
		Session::flash('success', 'Se agregó la notificacion de calendario con éxito.');
		return redirect()->route('notificaciones');
	}


}
