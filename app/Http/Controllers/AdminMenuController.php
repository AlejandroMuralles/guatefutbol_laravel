<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection; 
use Auth;

class AdminMenuController {

	public function __construct(){	}

    public function compose($view)
    {        

        $menu = new Collection();

        $menu->push((object)['title' => 'Dashboard', 'url' => route('dashboard'), 'class' => '' ,'icon' => 'fa fa-dashboard']);
        $menu->push((object)['title' => 'Anuncios', 'url' => route('anuncios'), 'class' => '' ,'icon' => 'fa fa-file']);
		$menu->push((object)['title' => 'Monitorear', 'url' => route('monitorear_jornada',[21,0,0,0,0]), 'class' => '' ,'icon' => 'fa fa-dashboard']);
		$menu->push((object)['title' => 'Configuracion', 'url' => route('configuraciones'), 'class' => '' ,'icon' => 'fa fa-location-arrow']);
		$menu->push((object)['title' => 'Estadios', 'url' => route('estadios'), 'class' => '' ,'icon' => 'fa fa-location-arrow']);
		$menu->push((object)['title' => 'Equipos', 'url' => route('equipos'), 'class' => '' ,'icon' => 'fa fa-users']);
		$menu->push((object)['title' => 'Eventos', 'url' => route('eventos'), 'class' => '' ,'icon' => 'fa fa-users']);
		$menu->push((object)['title' => 'Ligas', 'url' => route('ligas'), 'class' => '' ,'icon' => 'fa fa-users']);
		$menu->push((object)['title' => 'Historial Campeon', 'url' => route('historial_campeones'), 'class' => '' ,'icon' => 'fa fa-users']);
		$menu->push((object)['title' => 'Personas', 'url' => route('personas'), 'class' => '' ,'icon' => 'fa fa-users']);
		$menu->push((object)['title' => 'Pais', 'url' => route('paises'), 'class' => '' ,'icon' => 'fa fa-users']);
		$menu->push((object)['title' => 'Departamentos', 'url' => route('departamentos'), 'class' => '' ,'icon' => 'fa fa-users']);
        $menu->push((object)['title' => 'Usuarios', 'url' => route('usuarios'), 'class' => '' ,'icon' => 'fa fa-users']);
        $menu->push((object)['title' => 'Usuarios APP', 'url' => route('users_app'), 'class' => '' ,'icon' => 'fa fa-users']);
        $menu->push((object)['title' => 'Notificaciones', 'url' => route('notificaciones'), 'class' => '' ,'icon' => 'fa fa-bell']);
				
		$view->menu = $menu;
		/* GET USUARIO */
		$view->usuario = Auth::user();

    }

}