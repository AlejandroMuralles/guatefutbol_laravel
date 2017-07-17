<?php

namespace App\Http\Controllers;

use App\App\Repositories\PosicionesRepo;
use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\ConfiguracionRepo;
use App\App\Repositories\PartidoRepo;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\GoleadorRepo;
use App\App\Repositories\PorteroRepo;
use App\App\Repositories\EventoPartidoRepo;
use App\App\Repositories\EstadioRepo;
use App\App\Repositories\TablaAcumuladaRepo;
use App\App\Repositories\PlantillaRepo;
use App\App\Repositories\EquipoRepo;
use App\App\Repositories\HistorialCampeonRepo;

use App\App\ExtraEntities\FichaPartido;

use View;

class PublicController extends BaseController {

	protected $posicionesRepo;
	protected $campeonatoRepo;
	protected $configuracionRepo;
	protected $partidoRepo;
	protected $campeonatoEquipoRepo;
	protected $goleadorRepo;
	protected $porteroRepo;
	protected $eventoPartidoRepo;
	protected $estadioRepo;
	protected $tablaAcumuladaRepo;
	protected $plantillaRepo;
	protected $equipoRepo;
	protected $historialCampeonRepo;

	public function __construct(PosicionesRepo $posicionesRepo, ConfiguracionRepo $configuracionRepo, CampeonatoRepo $campeonatoRepo, 
		PartidoRepo $partidoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, GoleadorRepo $goleadorRepo, EventoPartidoRepo $eventoPartidoRepo,EstadioRepo $estadioRepo, TablaAcumuladaRepo $tablaAcumuladaRepo, PorteroRepo $porteroRepo, PlantillaRepo $plantillaRepo,EquipoRepo $equipoRepo, HistorialCampeonRepo $historialCampeonRepo)
	{
		$this->posicionesRepo = $posicionesRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		$this->partidoRepo = $partidoRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->goleadorRepo = $goleadorRepo;
		$this->porteroRepo = $porteroRepo;
		$this->configuracionRepo = $configuracionRepo;
		$this->eventoPartidoRepo = $eventoPartidoRepo;
		$this->estadioRepo = $estadioRepo;
		$this->tablaAcumuladaRepo = $tablaAcumuladaRepo;
		$this->plantillaRepo = $plantillaRepo;
		$this->equipoRepo = $equipoRepo;
		$this->historialCampeonRepo = $historialCampeonRepo;
		View::composer('layouts.publico', 'App\Http\Controllers\PublicMenuController');
	}

	public function posiciones($ligaId, $campeonatoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], [2,3]);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos);
		return view('publico/posiciones', compact('posiciones','campeonato','ligaId','campeonatos','configuracion'));
	}

	public function posicionesLocal($ligaId, $campeonatoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], [2,3]);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 1, $partidos, $equipos);
		return View::make('publico/posiciones', compact('posiciones','campeonato','ligaId','campeonatos','configuracion'));
	}

	public function posicionesVisita($ligaId, $campeonatoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], [2,3]);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 2, $partidos, $equipos);
		return View::make('publico/posiciones', compact('posiciones','campeonato','ligaId','campeonatos','configuracion'));
	}

	public function tablaAcumulada($ligaId, $campeonatoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$ta = $this->tablaAcumuladaRepo->getByCampeonato($campeonato->id);
		if(count($ta) > 0)
		{
			$partidosC1 = $this->partidoRepo->getByCampeonatoByFaseByEstado($ta[0]->campeonato1_id, ['R'], [2,3]);
			$partidosC2 = $this->partidoRepo->getByCampeonatoByFaseByEstado($ta[0]->campeonato2_id, ['R'], [2,3]);
			$partidos = $partidosC1->merge($partidosC2);
			$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
			$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos, 1);
			return View::make('publico/acumulada', compact('posiciones','campeonato','ligaId','campeonatos','configuracion'));
		}
		else
		{
			$partidos = $this->partidoRepo->getByCampeonatoByFase($campeonato->id, 2);
			$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
			$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos, 1);
			return View::make('publico/acumulada', compact('posiciones','campeonato','ligaId','campeonatos','configuracion'));
		}
	}

	public function goleadores($ligaId, $campeonatoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$goleadores = $this->goleadorRepo->getGoleadores($campeonato);
		return View::make('publico/goleadores', compact('goleadores','campeonato','campeonatos','ligaId','configuracion'));
	}

	public function porteros($ligaId, $campeonatoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$porteros = $this->porteroRepo->getPorteros($campeonato->id);
		$ligaId = $campeonato->liga;
		return View::make('publico/porteros', compact('porteros','campeonato','campeonatos','configuracion','ligaId'));
	}

	public function plantilla($ligaId, $campeonatoId, $equipoId)
	{
		$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$equipo = null;
		if($equipoId != 0){
			$equipo = $this->equipoRepo->find($equipoId);
		}
		$equipos = $this->campeonatoEquipoRepo->getByCampeonato($campeonato->id)->pluck('nombre','id')->toArray();
		$plantilla = $this->plantillaRepo->getPlantilla($campeonato, $equipoId);
		return View::make('publico/plantilla', compact('plantilla','campeonato','campeonatos','equipos','equipo','equipoId','ligaId'));
	}

	public function calendario($ligaId, $campeonatoId, $completo)
	{
		$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}

		$jornadas = array();

		if($completo == 0)
		{
			$configuracion = $this->configuracionRepo->find(1);
			$diasInicio = $configuracion->parametro1;
			$diasFin = $configuracion->parametro2;

			$fechaInicio = $this->getFecha($diasInicio . ' day');
			$fechaFin = $this->getFecha($diasFin . ' day');

			$partidos = $this->partidoRepo->getByCampeonatoByFechas($campeonato->id, $fechaInicio, $fechaFin);

		}
		else
		{
			$partidos = $this->partidoRepo->getByCampeonato($campeonato->id);			
		}

		foreach($partidos as $partido){
			$jornadas[$partido->jornada_id]['jornada'] = $partido->jornada;
			$jornadas[$partido->jornada_id]['partidos'][] = $partido;	
		}

		$configuracion = $this->configuracionRepo->find(2);
		return View::make('publico/calendario', compact('jornadas','campeonato','campeonatos','ligaId','configuracion','completo'));
	}

	public function calendarioEquipo($ligaId, $campeonatoId, $equipoId)
	{
		$equipo = $this->equipoRepo->find($equipoId);
		$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		
		$partidos = $this->partidoRepo->getByCampeonatoByEquipo($campeonato->id, $equipoId);

		/*foreach($partidos as $partido){
			$jornadas[$partido->jornada_id]['jornada'] = $partido->jornada;
			$jornadas[$partido->jornada_id]['partidos'][] = $partido;	
		}*/
		$ligaId = $campeonato->liga;
		$configuracion = $this->configuracionRepo->find(2);
		return View::make('publico/calendario_equipo', compact('partidos','campeonato','campeonatos','equipoId','ligaId','equipo','configuracion'));
	}

	public function ficha($partidoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$partido = $this->partidoRepo->find($partidoId);
		$ficha = new FichaPartido();
		$eventos = array();
		$ficha->generarEventos($partido, $eventos);
		$ligaId = $partido->campeonato->liga_id;
		return View::make('publico/ficha', compact('partido','ficha','partidos','ligaId','configuracion'));
	}

	public function enVivo($partidoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$partido = $this->partidoRepo->find($partidoId);
		$eventos = array();
		$eventos = $this->eventoPartidoRepo->getEnVivo($partidoId);
		$ligaId = $partido->campeonato->liga_id;
		return View::make('publico/envivo', compact('partido','eventos','ligaId','configuracion'));
	}

	public function miniPosiciones($ligaId, $campeonatoId)
	{
		$campeonatos = $this->campeonatoRepo->getListCampeonatosPublicados($ligaId);
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$configuracion = $this->configuracionRepo->find(5);
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, 2, [2,3]);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos);
		return View::make('publico/mini_posiciones', compact('campeonato','ligaId','campeonatos','configuracion','posiciones'));
	}

	public function jsonMiniPosiciones($ligaId, $campeonatoId)
	{
		$campeonatos = $this->campeonatoRepo->getListCampeonatosPublicados($ligaId);
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, 2, [2,3]);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos);
		return json_encode($posiciones);
	}

	public function miniCalendario($ligaId, $campeonatoId, $completo)
	{
		$campeonatos = $this->campeonatoRepo->getListCampeonatosPublicados($ligaId);
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		
		$jornadas = array();

		if($completo == 0)
		{
			$configuracion = $this->configuracionRepo->find(1);
			$diasInicio = $configuracion->parametro1;
			$diasFin = $configuracion->parametro2;

			$fechaInicio = $this->getFecha($diasInicio . ' day');
			$fechaFin = $this->getFecha($diasFin . ' day');

			$partidos = $this->partidoRepo->getByCampeonatoByFechas($campeonato->id, $fechaInicio, $fechaFin);

		}
		else
		{
			$partidos = $this->partidoRepo->getByCampeonato($campeonato->id);
			
		}

		foreach($partidos as $partido){
			$jornadas[$partido->jornada_id]['jornada'] = $partido->jornada;

			$jornadas[$partido->jornada_id]['partidos'][] = $partido;	
		}
		//dd($jornadas);
		$configuracion = $this->configuracionRepo->find(2);
		return View::make('publico/mini_calendario', compact('jornadas','campeonato','campeonatos','completo','configuracion','ligaId'));
	}

	public function jsonMiniCalendario($ligaId, $campeonatoId, $completo)
	{
		$campeonatos = $this->campeonatoRepo->getListCampeonatosPublicados($ligaId);
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		
		$jornadas = array();

		if($completo == 0)
		{
			$configuracion = $this->configuracionRepo->find(1);
			$diasInicio = $configuracion->parametro1;
			$diasFin = $configuracion->parametro2;

			$fechaInicio = $this->getFecha($diasInicio . ' day');
			$fechaFin = $this->getFecha($diasFin . ' day');

			$partidos = $this->partidoRepo->getByCampeonatoByFechas($campeonato->id, $fechaInicio, $fechaFin);

		}
		else
		{
			$partidos = $this->partidoRepo->getByCampeonato($campeonato->id);
			
		}

		foreach($partidos as $partido){
			$jornadas[$partido->jornada_id]['jornada'] = $partido->jornada;

			$p['id'] = $partido->id;
			$p['equipolocal'] = $partido->equipoLocal->nombre;
			$p['equipovisita'] = $partido->equipoVisita->nombre;
			$p['golesLocal'] = $partido->goles_local;
			$p['golesVisita'] =$partido->goles_visita;
			$p['imagenLocal'] = $partido->equipoLocal->imagen;
			$p['imagenVisita'] = $partido->equipoVisita->imagen;
			$p['fecha'] = date('d/m/Y', strtotime($partido->fecha));
			$p['hora'] = date('H:i', strtotime($partido->fecha));

			$jornadas[$partido->jornada_id]['partidos'][] = $p;	
		}
		$configuracion = $this->configuracionRepo->find(2);
		return json_encode($jornadas);
	}

	public function campeones($ligaId, $campeonatoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$campeones = $this->historialCampeonRepo->all('fecha');
		return View::make('publico/campeones', compact('campeones','ligaId','campeonato'));
	}	

	public function dashboard($ligaId, $campeonatoId)
	{
		$campeonatos = $this->campeonatoRepo->getListCampeonatosPublicados($ligaId);
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}

		$jornadas = array();

		$configuracion = $this->configuracionRepo->find(1);
		$diasInicio = $configuracion->parametro1;
		$diasFin = $configuracion->parametro2;
		$fechaInicio = $this->getFecha($diasInicio . ' day');
		$fechaFin = $this->getFecha($diasFin . ' day');

		$partidosDB = $this->partidoRepo->getByCampeonatoByFechas($campeonato->id, $fechaInicio, $fechaFin);
		//$partidosDB = $this->partidoRepo->getByCampeonatoByFechas($campeonato->id, '2016-4-7', '2016-4-15');

		$partidos = [];

		foreach($partidosDB as $partido)
		{
			$eventosDB = $this->eventoPartidoRepo->getByEventos($partido->id, array(6,7,8));
		
			$i = 0;
			$golesLocal = 0;
			$golesVisita = 0;
			$es = [];
			foreach($eventosDB as $evento)
			{
				$es[$i]['resultado'] = '';
				if($evento->evento_id == 6 || $evento->evento_id == 7 || $evento->evento_id == 8)
				{
					if($evento->equipo_id == $partido->equipo_local_id){
						$golesLocal++;
					}
					else{
						$golesVisita++;
					}
					$es[$i]['resultado'] = $golesLocal . ' - ' . $golesVisita;
				}
				if($evento->equipo_id == $partido->equipo_local_id){
					$es[$i]['minuto_local'] = $evento->minuto;
					$es[$i]['nombre_local'] = $evento->jugador1->primer_nombre . ' ' . $evento->jugador1->primer_apellido;
					if($evento->evento_id == 7)
						$es[$i]['nombre_local'] .= ' (ag)';
					$es[$i]['imagen_local'] = $evento->imagen->ruta;
					$es[$i]['minuto_visita'] = '';
					$es[$i]['nombre_visita'] = '';
				}
				else{
					$es[$i]['minuto_local'] = '';
					$es[$i]['nombre_local'] = '';
					$es[$i]['minuto_visita'] = $evento->minuto;
					$es[$i]['nombre_visita'] = $evento->jugador1->primer_nombre . ' ' . $evento->jugador1->primer_apellido;
					if($evento->evento_id == 7)
						$es[$i]['nombre_visita'] = '(ag) ' . $es[$i]['nombre_visita'];
					$es[$i]['imagen_visita'] = $evento->imagen->ruta;
				}				
				$i++;
			}

			$dato['partido'] = $partido;
			$dato['eventos'] = $es;

			$partidos[] = $dato; 

		}

		$configuracion = $this->configuracionRepo->find(4);
		return View::make('publico/dashboard', compact('campeonato','campeonatos','ligaId','configuracion','partidos'));
	}

	public function partidosScroll()
	{
		$fechaInicio = '2017-07-15';
		$fechaFin = '2017-07-30';
		$partidos = $this->partidoRepo->getBetweenFechas($fechaInicio, $fechaFin);
		return View::make('publico/partidos_scroll',compact('partidos'));
	}

	
	function getFecha($extraDays){
		$fecha = date('Y-m-d');
		$nuevafecha = strtotime ( $extraDays , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		return $nuevafecha;
	}


}