<?php

namespace Blog\Repositories;

class CalendarioRepo {

	public function __construct (ConfiguracionRepo $configuracionRepo)
	{
		$this->configuracionRepo = $configuracionRepo;
	}

	public function getCalendario($campeonatoId, $completo)
	{
		$partidos = array();
		if($completo == 1)
		{
			$sql = '
				SELECT partido.id, equipoLocal.nombre equipoLocal, equipoVisita.nombre equipoVisita, golesLocal, golesVisita, 
					equipoLocal.ruta rutaLocal, equipoVisita.ruta rutaVisita, fecha, tp.nombre jornada, estadio.nombre estadio,
					ep.nombre estado
				FROM partido, tipo_partido tp, equipo equipoLocal, equipo equipoVisita, estadio, estado_partido ep
				WHERE campeonato = ' . $campeonatoId . '
					AND tipopartido = tp.id
					AND equipoLocal.id = partido.equipolocal
					AND equipoVisita.id = partido.equipovisita
					AND partido.estadio = estadio.id
					AND partido.estado = ep.id
				ORDER BY fecha ASC
			';
			$partidos = \DB::select(\DB::raw($sql));
		}
		else
		{
			$configuracion = $this->configuracionRepo->getById(1);
			$fechaInicio = $this->getFechaSegunDia($configuracion->parametro1);
			$fechaFin = $this->getFechaSegunDia($configuracion->parametro2);
			/*$fechaInicio = '2015-08-01';
			$fechaFin = '2015-08-02';*/
			$sql = "
				SELECT partido.id, equipoLocal.nombre equipoLocal, equipoVisita.nombre equipoVisita, golesLocal, golesVisita, 
					equipoLocal.ruta rutaLocal, equipoVisita.ruta rutaVisita, fecha, tp.nombre jornada, estadio.nombre estadio,
					ep.nombre estado
				FROM partido, tipo_partido tp, equipo equipoLocal, equipo equipoVisita, estadio, estado_partido ep
				WHERE campeonato = " . $campeonatoId . "
					AND fecha BETWEEN '" . $fechaInicio . " 00:00:00' AND '"  . $fechaFin . " 23:59:59'
					AND tipopartido = tp.id 
					AND equipoLocal.id = partido.equipolocal
					AND equipoVisita.id = partido.equipovisita
					AND partido.estadio = estadio.id
					AND partido.estado = ep.id
				ORDER BY fecha ASC
			";
			$partidos = \DB::select(\DB::raw($sql));
		}
		$jornadas = $this->groupByJornada($partidos);
		return $jornadas;
	}

	public function groupByJornada($partidos){
		$jornadas = array();
		$i = 0;
		$jornada = '';
		$partidosByJornada = array();
		$newkey = 0;
		foreach($partidos as $partido){

			if($jornada == '')
			{
				$partidosByJornada[] = $partido;
				$jornada = $partido->jornada;
			}
			else
			{
				if($jornada != $partido->jornada){
					$jornadas[$i]['jornada'] = $jornada;
					$jornadas[$i]['partidos'] = $partidosByJornada;
					$i++;
					$jornada = $partido->jornada;
					$partidosByJornada = array();
					$partidosByJornada[] = $partido;
				}
				else
				{
					$jornada = $partido->jornada;
					$partidosByJornada[] = $partido;
				}
			}
		}
		$jornadas[$i]['jornada'] = $jornada;
		$jornadas[$i]['partidos'] = $partidosByJornada;
		return $jornadas;
	}

	public function getFechaSegunDia($diasSumados)
	{
		$today = date('Y-m-d');
		$nuevafecha = strtotime ( $diasSumados . ' day' , strtotime ( $today ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		return $nuevafecha;
	}

}