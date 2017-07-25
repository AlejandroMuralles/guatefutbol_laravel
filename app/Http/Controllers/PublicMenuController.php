<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection; 
use Auth;
use App\App\Repositories\LigaRepo;
use App\App\Repositories\PartidoRepo;

class PublicMenuController {

	public function __construct(){	}

    public function compose($view)
    {        

    	$ligaRepo = new LigaRepo();
    	$partidoRepo = new partidoRepo();

    	$menu = new Collection();

		$view->ligas = $ligaRepo->getByEstado(['A']);

		$view->partidos = $partidoRepo->getByDia();

    }

}