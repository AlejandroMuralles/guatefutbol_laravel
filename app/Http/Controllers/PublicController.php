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
use App\App\Repositories\AlineacionRepo;

use App\App\ExtraEntities\FichaPartido;
use App\App\ExtraEntities\RachaEquipo;
use App\App\ExtraEntities\AlineacionPartido;

use View, Cache;

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
	protected $alineacionRepo;

	public function __construct(PosicionesRepo $posicionesRepo, ConfiguracionRepo $configuracionRepo, CampeonatoRepo $campeonatoRepo,
		PartidoRepo $partidoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, GoleadorRepo $goleadorRepo, EventoPartidoRepo $eventoPartidoRepo,
		EstadioRepo $estadioRepo, TablaAcumuladaRepo $tablaAcumuladaRepo, PorteroRepo $porteroRepo, PlantillaRepo $plantillaRepo,EquipoRepo $equipoRepo, 
		HistorialCampeonRepo $historialCampeonRepo, AlineacionRepo $alineacionRepo)
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
		$this->alineacionRepo = $alineacionRepo;
		View::composer('layouts.publico', 'App\Http\Controllers\PublicMenuController');
	}

	public function posiciones($ligaId, $campeonatoId)
	{
		$data = Cache::remember('publico.posiciones'.$ligaId.'-'.$campeonatoId, 1, function() use($ligaId, $campeonatoId) {
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

				$data['configuracion'] = $configuracion;
				$data['campeonatos'] = $campeonatos;
				$data['campeonato'] = $campeonato;
				$data['posiciones'] = $posiciones;
				return $data;
		});

		$configuracion = $data['configuracion'];
		$campeonatos = $data['campeonatos'];
		$campeonato = $data['campeonato'];
		$posiciones = $data['posiciones'];

		return view('publico/posiciones', compact('posiciones','campeonato','ligaId','campeonatos','configuracion'));
	}

	public function posicionesLocal($ligaId, $campeonatoId)
	{
		$data = Cache::remember('publico.posicionesLocal'.$ligaId.'-'.$campeonatoId, 1, function() use($ligaId, $campeonatoId) {
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

			$data['configuracion'] = $configuracion;
			$data['campeonatos'] = $campeonatos;
			$data['campeonato'] = $campeonato;
			$data['posiciones'] = $posiciones;
			return $data;
		});

		$configuracion = $data['configuracion'];
		$campeonatos = $data['campeonatos'];
		$campeonato = $data['campeonato'];
		$posiciones = $data['posiciones'];
		return View::make('publico/posiciones', compact('posiciones','campeonato','ligaId','campeonatos','configuracion'));
	}

	public function posicionesVisita($ligaId, $campeonatoId)
	{
		$data = Cache::remember('publico.posicionesVisita'.$ligaId.'-'.$campeonatoId, 1, function() use($ligaId, $campeonatoId) {
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

			$data['configuracion'] = $configuracion;
			$data['campeonatos'] = $campeonatos;
			$data['campeonato'] = $campeonato;
			$data['posiciones'] = $posiciones;
			return $data;
		});

		$configuracion = $data['configuracion'];
		$campeonatos = $data['campeonatos'];
		$campeonato = $data['campeonato'];
		$posiciones = $data['posiciones'];

		return View::make('publico/posiciones', compact('posiciones','campeonato','ligaId','campeonatos','configuracion'));
	}

	public function tablaAcumulada($ligaId, $campeonatoId)
	{
		$data = Cache::remember('publico.tablaAcumulada'.$ligaId.'-'.$campeonatoId, 1, function() use($ligaId, $campeonatoId) {
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
				$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos, 1, $ta);
			}
			else
			{
				$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], [2,3]);
				$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
				$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos, 1, $ta);
			}

			$data['configuracion'] = $configuracion;
			$data['campeonatos'] = $campeonatos;
			$data['campeonato'] = $campeonato;
			$data['posiciones'] = $posiciones;
			return $data;
		});

		$configuracion = $data['configuracion'];
		$campeonatos = $data['campeonatos'];
		$campeonato = $data['campeonato'];
		$posiciones = $data['posiciones'];
		return View::make('publico/acumulada', compact('posiciones','campeonato','ligaId','campeonatos','configuracion'));
	}

	public function goleadores($ligaId, $campeonatoId)
	{
		$data = Cache::remember('publico.goleadores'.$ligaId.'-'.$campeonatoId, 1, function() use($ligaId, $campeonatoId) {
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

			$data['configuracion'] = $configuracion;
			$data['campeonatos'] = $campeonatos;
			$data['campeonato'] = $campeonato;
			$data['goleadores'] = $goleadores;
			return $data;
		});

		$configuracion = $data['configuracion'];
		$campeonatos = $data['campeonatos'];
		$campeonato = $data['campeonato'];
		$goleadores = $data['goleadores'];
		return View::make('publico/goleadores', compact('goleadores','campeonato','campeonatos','ligaId','configuracion'));
	}

	public function porteros($ligaId, $campeonatoId)
	{
		$data = Cache::remember('publico.porteros'.$ligaId.'-'.$campeonatoId, 1, function() use($ligaId, $campeonatoId) {
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

			$data['configuracion'] = $configuracion;
			$data['campeonatos'] = $campeonatos;
			$data['campeonato'] = $campeonato;
			$data['porteros'] = $porteros;
			return $data;
		});
		$configuracion = $data['configuracion'];
		$campeonatos = $data['campeonatos'];
		$campeonato = $data['campeonato'];
		$porteros = $data['porteros'];
		return View::make('publico/porteros', compact('porteros','campeonato','campeonatos','configuracion','ligaId'));
	}

	public function plantilla($ligaId, $campeonatoId, $equipoId)
	{
		$data = Cache::remember('publico.plantilla'.$ligaId.'-'.$campeonatoId.'-'.$equipoId, 1, function() use($ligaId, $campeonatoId,$equipoId) {
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

			$data['plantilla'] = $plantilla;
			$data['campeonato'] = $campeonato;
			$data['campeonatos'] = $campeonatos;
			$data['equipos'] = $equipos;
			$data['equipo'] = $equipo;
			return $data;
		});

		$plantilla = $data['plantilla'];
		$campeonato = $data['campeonato'];
		$campeonatos = $data['campeonatos'];
		$equipos = $data['equipos'];
		$equipo = $data['equipo'];
		return View::make('publico/plantilla', compact('plantilla','campeonato','campeonatos','equipos','equipo','equipoId','ligaId'));
	}

	public function calendario($ligaId, $campeonatoId, $completo)
	{
		$data = Cache::remember('publico.calendario'.$ligaId.'-'.$campeonatoId.'-'.$completo, 1, function() use($ligaId, $campeonatoId,$completo) {
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

			$data['jornadas'] = $jornadas;
			$data['campeonato'] = $campeonato;
			$data['campeonatos'] = $campeonatos;
			$data['configuracion'] = $configuracion;
			return $data;
		});

		$jornadas = $data['jornadas'];
		$campeonato = $data['campeonato'];
		$campeonatos = $data['campeonatos'];
		$configuracion = $data['configuracion'];

		return View::make('publico/calendario', compact('jornadas','campeonato','campeonatos','ligaId','configuracion','completo'));
	}

	public function calendarioEquipo($ligaId, $campeonatoId, $equipoId)
	{
		$data = Cache::remember('publico.calendarioEquipo'.$ligaId.'-'.$campeonatoId.'-'.$equipoId, 1, function() use($ligaId, $campeonatoId,$equipoId) {
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
			$configuracion = $this->configuracionRepo->find(2);

			$data['partidos'] = $partidos;
			$data['campeonato'] = $campeonato;
			$data['campeonatos'] = $campeonatos;
			$data['configuracion'] = $configuracion;
			$data['equipo'] = $equipo;
			return $data;

		});

		$partidos = $data['partidos'];
		$campeonato = $data['campeonato'];
		$campeonatos = $data['campeonatos'];
		$configuracion = $data['configuracion'];
		$equipo = $data['equipo'];
		return View::make('publico/calendario_equipo', compact('partidos','campeonato','campeonatos','equipoId','ligaId','equipo','configuracion'));
	}

	public function ficha($partidoId)
	{
		$data = Cache::remember('publico.ficha'.$partidoId, 1, function() use($partidoId) {
			$configuracion = $this->configuracionRepo->find(5);
			$partido = $this->partidoRepo->find($partidoId);
			$ficha = new FichaPartido();
			$eventos = array();
			$ficha->generarEventos($partido, $eventos);
			$ligaId = $partido->campeonato->liga_id;

			$data['partido'] = $partido;
			$data['ficha'] = $ficha;
			$data['ligaId'] = $ligaId;
			$data['configuracion'] = $configuracion;
			$data['arbitro'] = $partido->arbitro_central;
			$data['estadio'] = $partido->estadio;
			$data['equipoLocal'] = $partido->equipo_local;
			$data['equipoVisita'] = $partido->equipo_visita;
			return $data;

		});

		$partido = $data['partido'];
		$ficha = $data['ficha'];
		$ligaId = $data['ligaId'];
		$configuracion = $data['configuracion'];
		$equipoLocal = $data['equipoLocal'];
		$equipoVisita = $data['equipoVisita'];
		$arbitroCentral = $data['arbitro'];
		$estadio = $data['estadio'];
		return View::make('publico/ficha', compact('partido','ficha','ligaId','configuracion','arbitroCentral','estadio','equipoLocal','equipoVisita'));
	}

	public function previa($partidoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$partido = $this->partidoRepo->find($partidoId);
		$partidosLocal = $this->partidoRepo->getByCampeonatoByEquipoByFaseByEstadoBeforeFecha($partido->campeonato_id, $partido->equipo_local_id, ['R','F'], [3],$partido->fecha,'fecha','ASC',10);
		$partidosVisita = $this->partidoRepo->getByCampeonatoByEquipoByFaseByEstadoBeforeFecha($partido->campeonato_id, $partido->equipo_visita_id, ['R','F'], [3],$partido->fecha,'fecha','ASC',10);
		$ficha = new FichaPartido();
		$eventos = array();
		$ficha->generarEventos($partido, $eventos);
		$ligaId = $partido->campeonato->liga_id;
		
		$rachaLocal = $this->getRacha($partidosLocal, $partido->equipo_local);
		$rachaVisita = $this->getRacha($partidosVisita, $partido->equipo_visita);
		return View::make('publico/previa', compact('partido','ficha','ligaId','configuracion','rachaLocal','rachaVisita'));
	}

	public function alineaciones($partidoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$partido = $this->partidoRepo->find($partidoId);

		$alineacionLocal = $this->alineacionRepo->getJugadores($partido->id, $partido->equipo_local_id);
		$titularesLocales = [];
		$suplentesLocales = [];
		foreach($alineacionLocal as $al)
		{
			if($al->es_titular == 1){
				$titularesLocales[$al->persona_id] = new AlineacionPartido($al->persona);
			}
			else
			{
				$suplentesLocales[$al->persona_id] = new AlineacionPartido($al->persona);
			}
		}
		$dtLocal = $this->alineacionRepo->getTecnico($partido->id,$partido->equipo_local_id);

		$alineacionVisita = $this->alineacionRepo->getJugadores($partido->id, $partido->equipo_visita_id);
		$titularesVisita = [];
		$suplentesVisita = [];
		foreach($alineacionVisita as $av)
		{
			if($av->es_titular == 1){
				$titularesVisita[$av->persona_id] = new AlineacionPartido($av->persona);
			}
			else
			{
				$suplentesVisita[$av->persona_id] = new AlineacionPartido($av->persona);
			}
		}
		$dtVisita = $this->alineacionRepo->getTecnico($partido->id,$partido->equipo_visita_id);

		$eventos = $this->eventoPartidoRepo->getByEventos($partido->id, array(6,7,8,9,10,11));
		foreach($eventos as $evento)
		{
			if($evento->equipo_id == $partido->equipo_local_id){
				if($evento->evento_id == 6 || $evento->evento_id == 8)
				{
					if(isset($titularesLocales[$evento->jugador1_id])) $titularesLocales[$evento->jugador1_id]->goles[] = $evento->minuto;
					if(isset($suplentesLocales[$evento->jugador1_id])) $suplentesLocales[$evento->jugador1_id]->goles = $evento->minuto;
				}
				if($evento->evento_id == 9)
				{
					if(isset($titularesLocales[$evento->jugador1_id])) $titularesLocales[$evento->jugador1_id]->cambio = true;
					if(isset($titularesLocales[$evento->jugador1_id])) $titularesLocales[$evento->jugador1_id]->minuto_cambio = $evento->minuto;
					if(isset($titularesLocales[$evento->jugador2_id])) $titularesLocales[$evento->jugador2_id]->cambio = true;
					if(isset($titularesLocales[$evento->jugador2_id])) $titularesLocales[$evento->jugador2_id]->minuto_cambio = $evento->minuto;

					if(isset($suplentesLocales[$evento->jugador1_id])) $suplentesLocales[$evento->jugador1_id]->cambio = true;
					if(isset($suplentesLocales[$evento->jugador1_id])) $suplentesLocales[$evento->jugador1_id]->minuto_cambio = $evento->minuto;
					if(isset($suplentesLocales[$evento->jugador2_id])) $suplentesLocales[$evento->jugador2_id]->cambio = true;
					if(isset($suplentesLocales[$evento->jugador2_id])) $suplentesLocales[$evento->jugador2_id]->minuto_cambio = $evento->minuto;
				}
				if($evento->evento_id == 10)
				{
					if(isset($titularesLocales[$evento->jugador1_id])) $titularesLocales[$evento->jugador1_id]->amarillas[] = $evento->minuto;
					if(isset($suplentesLocales[$evento->jugador1_id])) $suplentesLocales[$evento->jugador1_id]->amarillas[] = $evento->minuto;
				}
				if($evento->evento_id == 11)
				{
					if($evento->doble_amarilla){
						if(isset($titularesLocales[$evento->jugador1_id])) $titularesLocales[$evento->jugador1_id]->amarillas[] = $evento->minuto;
						if(isset($suplentesLocales[$evento->jugador1_id])) $suplentesLocales[$evento->jugador1_id]->amarillas[] = $evento->minuto;
						if(isset($suplentesLocales[$evento->jugador1_id])) $suplentesLocales[$evento->jugador1_id]->roja = $evento->minuto;
						if(isset($suplentesLocales[$evento->jugador1_id])) $suplentesLocales[$evento->jugador1_id]->expulsado = true;
					}
				}
			}
			if($evento->equipo_id == $partido->equipo_visita_id){
				if($evento->evento_id == 6 || $evento->evento_id == 8)
				{
					if(isset($titularesVisita[$evento->jugador1_id])) $titularesVisita[$evento->jugador1_id]->goles[] = $evento->minuto;
					if(isset($suplentesVisita[$evento->jugador1_id])) $suplentesVisita[$evento->jugador1_id]->goles = $evento->minuto;
				}
				if($evento->evento_id == 9)
				{
					if(isset($titularesVisita[$evento->jugador1_id])) $titularesVisita[$evento->jugador1_id]->cambio = true;
					if(isset($titularesVisita[$evento->jugador1_id])) $titularesVisita[$evento->jugador1_id]->minuto_cambio = $evento->minuto;
					if(isset($titularesVisita[$evento->jugador2_id])) $titularesVisita[$evento->jugador2_id]->cambio = true;
					if(isset($titularesVisita[$evento->jugador2_id])) $titularesVisita[$evento->jugador2_id]->minuto_cambio = $evento->minuto;

					if(isset($suplentesVisita[$evento->jugador1_id])) $suplentesVisita[$evento->jugador1_id]->cambio = true;
					if(isset($suplentesVisita[$evento->jugador1_id])) $suplentesVisita[$evento->jugador1_id]->minuto_cambio = $evento->minuto;
					if(isset($suplentesVisita[$evento->jugador2_id])) $suplentesVisita[$evento->jugador2_id]->cambio = true;
					if(isset($suplentesVisita[$evento->jugador2_id])) $suplentesVisita[$evento->jugador2_id]->minuto_cambio = $evento->minuto;
				}
				if($evento->evento_id == 10)
				{
					if(isset($titularesVisita[$evento->jugador1_id])) $titularesVisita[$evento->jugador1_id]->amarillas[] = $evento->minuto;
					if(isset($suplentesVisita[$evento->jugador1_id])) $suplentesVisita[$evento->jugador1_id]->amarillas[] = $evento->minuto;
				}
				if($evento->evento_id == 11)
				{
					if($evento->doble_amarilla){
						if(isset($titularesVisita[$evento->jugador1_id])) $titularesVisita[$evento->jugador1_id]->amarillas[] = $evento->minuto;
						if(isset($titularesVisita[$evento->jugador1_id])) $titularesVisita[$evento->jugador1_id]->roja = $evento->minuto;
						if(isset($titularesVisita[$evento->jugador1_id])) $titularesVisita[$evento->jugador1_id]->expulsado = true;

						if(isset($suplentesVisita[$evento->jugador1_id])) $suplentesVisita[$evento->jugador1_id]->amarillas[] = $evento->minuto;
						if(isset($suplentesVisita[$evento->jugador1_id])) $suplentesVisita[$evento->jugador1_id]->roja = $evento->minuto;
						if(isset($suplentesVisita[$evento->jugador1_id])) $suplentesVisita[$evento->jugador1_id]->expulsado = true;
					}
					else{
						if(isset($titularesVisita[$evento->jugador1_id])) $titularesVisita[$evento->jugador1_id]->roja = $evento->minuto;
						if(isset($titularesVisita[$evento->jugador1_id])) $titularesVisita[$evento->jugador1_id]->expulsado = true;

						if(isset($suplentesVisita[$evento->jugador1_id])) $suplentesVisita[$evento->jugador1_id]->roja = $evento->minuto;
						if(isset($suplentesVisita[$evento->jugador1_id])) $suplentesVisita[$evento->jugador1_id]->expulsado = true;
					}
				}
			}
		}		
		return View::make('publico/alineaciones2', compact('partido','titularesLocales','suplentesLocales','titularesVisita','suplentesVisita','configuracion','dtLocal','dtVisita'));
	}

	private function getRacha($partidos, $equipo)
	{
		$racha = new RachaEquipo($equipo);
		foreach($partidos as $partido)
		{
			if($partido->equipo_local_id == $equipo->id)
			{
				if($partido->goles_local > $partido->goles_visita){ $racha->ganados++; $racha->racha[] = 'G'; }
				if($partido->goles_local < $partido->goles_visita){ $racha->perdidos++; $racha->racha[] = 'P'; }
				if($partido->goles_local == $partido->goles_visita){ $racha->empatados++; $racha->racha[] = 'E'; }
				$racha->goles_favor += $partido->goles_local;
				$racha->goles_contra += $partido->goles_visita;
			}
			elseif($partido->equipo_visita_id == $equipo->id)
			{
				if($partido->goles_visita > $partido->goles_local){ $racha->ganados++; $racha->racha[] = 'G'; }
				if($partido->goles_visita < $partido->goles_local){ $racha->perdidos++; $racha->racha[] = 'P'; }
				if($partido->goles_visita == $partido->goles_local){ $racha->empatados++; $racha->racha[] = 'E'; }
				$racha->goles_favor += $partido->goles_visita;
				$racha->goles_contra += $partido->goles_local;
			}
		}
		return $racha;
	}

	public function narracion($partidoId)
	{
		$configuracion = $this->configuracionRepo->find(5);
		$partido = $this->partidoRepo->find($partidoId);
		$eventos = array();
		$eventos = $this->eventoPartidoRepo->getEnVivo($partidoId);
		$ligaId = $partido->campeonato->liga_id;
		return View::make('publico/narracion', compact('partido','eventos','ligaId','configuracion','arbitroCentral','estadio','equipoLocal','equipoVisita'));
	}

	public function enVivo($partidoId)
	{
		$data = Cache::remember('publico.envivo'.$partidoId, 1, function() use($partidoId) {
			$configuracion = $this->configuracionRepo->find(5);
			$partido = $this->partidoRepo->find($partidoId);
			$eventos = array();
			$eventos = $this->eventoPartidoRepo->getEnVivo($partidoId);
			$ligaId = $partido->campeonato->liga_id;

			$data['partido'] = $partido;
			$data['eventos'] = $eventos;
			$data['ligaId'] = $ligaId;
			$data['configuracion'] = $configuracion;
			$data['arbitro'] = $partido->arbitro_central;
			$data['estadio'] = $partido->estadio;
			$data['equipoLocal'] = $partido->equipo_local;
			$data['equipoVisita'] = $partido->equipo_visita;
			return $data;
		});
		$partido = $data['partido'];
		$eventos = $data['eventos'];
		$ligaId = $data['ligaId'];
		$configuracion = $data['configuracion'];
		$equipoLocal = $data['equipoLocal'];
		$equipoVisita = $data['equipoVisita'];
		$arbitroCentral = $data['arbitro'];
		$estadio = $data['estadio'];
		return View::make('publico/envivo', compact('partido','eventos','ligaId','configuracion','arbitroCentral','estadio','equipoLocal','equipoVisita'));
	}

	public function miniPosiciones($ligaId, $campeonatoId)
	{
		$data = Cache::remember('publico.miniPosiciones'.$ligaId.'-'.$campeonatoId, 1, function() use($ligaId, $campeonatoId) {
			$campeonatos = $this->campeonatoRepo->getByEstado($ligaId, ['A'])->pluck('nombre','id')->toArray();
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}
			$configuracion = $this->configuracionRepo->find(5);
			$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], [2,3]);
			$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
			$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos);

			$data['configuracion'] = $configuracion;
			$data['campeonato'] = $campeonato;
			$data['campeonatos'] = $campeonatos;
			$data['posiciones'] = $posiciones;
			return $data;

		});

		$configuracion = $data['configuracion'];
		$campeonato = $data['campeonato'];
		$campeonatos = $data['campeonatos'];
		$posiciones = $data['posiciones'];
		return View::make('publico/mini_posiciones', compact('campeonato','ligaId','campeonatos','configuracion','posiciones'));
	}

	public function jsonMiniPosiciones($ligaId, $campeonatoId)
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
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], [2,3]);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		$posiciones = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos);
		return json_encode($posiciones);
	}

	public function miniCalendario($ligaId, $campeonatoId, $completo)
	{
		$data = Cache::remember('publico.miniCalendario'.$ligaId.'-'.$campeonatoId.'-'.$completo, 1, function() use($ligaId, $campeonatoId, $completo) {
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
			//dd($jornadas);
			$configuracion = $this->configuracionRepo->find(2);

			$data['jornadas'] = $jornadas;
			$data['campeonato'] = $campeonato;
			$data['campeonatos'] = $campeonatos;
			$data['configuracion'] = $configuracion;
			return $data;
		});

		$jornadas = $data['jornadas'];
		$campeonato = $data['campeonato'];
		$campeonatos = $data['campeonatos'];
		$configuracion = $data['configuracion'];

		return View::make('publico/mini_calendario', compact('jornadas','campeonato','campeonatos','completo','configuracion','ligaId'));
	}

	public function jsonMiniCalendario($ligaId, $campeonatoId, $completo)
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
		$data = Cache::remember('publico.dashboard'.$ligaId.'-'.$campeonatoId, 1, function() use($ligaId, $campeonatoId) {
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

			$configuracion = $this->configuracionRepo->find(3);
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
						$es[$i]['imagen_local'] = $evento->evento->imagen;
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
						$es[$i]['imagen_visita'] = $evento->evento->imagen;
					}
					$i++;
				}

				$dato['partido'] = $partido;
				$dato['eventos'] = $es;

				$partidos[] = $dato;

			}

			$configuracion = $this->configuracionRepo->find(4);

			$data['campeonato'] = $campeonato;
			$data['campeonatos'] = $campeonatos;
			$data['configuracion'] = $configuracion;
			$data['partidos'] = $partidos;
			return $data;
		});

		$campeonato = $data['campeonato'];
		$campeonatos = $data['campeonatos'];
		$configuracion = $data['configuracion'];
		$partidos = $data['partidos'];

		return View::make('publico/dashboard', compact('campeonato','campeonatos','ligaId','configuracion','partidos'));
	}

	public function partidosScroll()
	{
		$partidos = Cache::remember('publico.partidoScroll', 1, function(){
			$configuracion = $this->configuracionRepo->find(7);
			$diasInicio = $configuracion->parametro1;
			$diasFin = $configuracion->parametro2;

			$fechaInicio = $this->getFecha($diasInicio . ' day');
			$fechaFin = $this->getFecha($diasFin . ' day');
			//$fechaInicio = '2017-01-15';
			//$fechaFin = '2017-01-30';
			$partidos = $this->partidoRepo->getBetweenFechas($fechaInicio, $fechaFin);

			return $partidos;

		});

		return View::make('publico/partidos_scroll',compact('partidos'));
	}


	function getFecha($extraDays){
		$fecha = date('Y-m-d');
		$nuevafecha = strtotime ( $extraDays , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		return $nuevafecha;
	}


}

