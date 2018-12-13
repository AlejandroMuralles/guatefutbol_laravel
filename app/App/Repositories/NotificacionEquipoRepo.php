<?php

namespace App\App\Repositories;

use App\App\Entities\NotificacionEquipo;
use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\CampeonatoEquipoRepo;

class NotificacionEquipoRepo extends BaseRepo{

	protected $campeonatoRepo;
	protected $campeonatoEquipoRepo;

	public function __construct(CampeonatoRepo $campeonatoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo)
	{
		$this->campeonatoRepo = $campeonatoRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
	}

	public function getModel()
	{
		return new NotificacionEquipo;
	}

	public function getEquiposByUser($userId, $ligaId)
	{
		$equipos = [];
		$campeonato = $this->campeonatoRepo->getActual($ligaId);		
		if(!is_null($campeonato))
		{
			$equiposCampeonato = $this->campeonatoEquipoRepo->getEquipos($campeonato->id);
			foreach($equiposCampeonato as $ec)
			{
                $e['id'] = $ec->equipo_id;
                $e['logo'] = $ec->equipo->logo;
				$e['nombre'] = $ec->equipo->nombre;
				$e['checked'] = false;
				$equipos[$ec->equipo_id] = $e;
			}
			$notificaciones = NotificacionEquipo::where('user_app_id','=',$userId)->get();
			foreach($notificaciones as $n)
			{
				if(isset($equipos[$n->equipo_id]))
				{
					$equipos[$n->equipo_id]['checked'] = true;
				}
			}
		}
		return $equipos;
	}

	public function getByUserByEquipo($userId, $equipoId)
	{
		return NotificacionEquipo::where('user_app_id','=',$userId)
						->where('equipo_id','=',$equipoId)->get();
	}

	public function getByUser($userId)
	{
		return NotificacionEquipo::where('user_app_id','=',$userId)->get();
	}

	public function getByEquipos($equipos)
	{
		return NotificacionEquipo::whereIn('equipo_id',$equipos)->get();
	}

}