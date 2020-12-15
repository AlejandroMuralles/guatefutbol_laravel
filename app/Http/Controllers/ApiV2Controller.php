<?php

namespace App\Http\Controllers;

use App\App\Repositories\PosicionesRepo;
use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\ConfiguracionRepo;
use App\App\Repositories\PartidoRepo;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\PlantillaRepo;
use App\App\Repositories\GoleadorRepo;
use App\App\Repositories\PorteroRepo;
use App\App\Repositories\EventoPartidoRepo;
use App\App\Repositories\AlineacionRepo;
use App\App\Repositories\LigaRepo;
use App\App\Repositories\EstadioRepo;
use App\App\Repositories\EquipoRepo;
use App\App\Repositories\TablaAcumuladaRepo;
use App\App\Repositories\AnuncioRepo;

use Cache;
use stdClass;

class ApiV2Controller extends BaseController {

	protected $posicionesRepo;
	protected $campeonatoRepo;
	protected $configuracionRepo;
	protected $partidoRepo;
	protected $campeonatoEquipoRepo;
	protected $plantillaRepo;
	protected $goleadorRepo;
	protected $porteroRepo;
	protected $eventoPartidoRepo;
	protected $alineacionRepo;
	protected $ligaRepo;
	protected $estadioRepo;
	protected $equipoRepo;
    protected $tablaAcumuladaRepo;
    protected $anuncioRepo;

	public function __construct(PosicionesRepo $posicionesRepo, ConfiguracionRepo $configuracionRepo, CampeonatoRepo $campeonatoRepo,
		PartidoRepo $partidoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, GoleadorRepo $goleadorRepo, EventoPartidoRepo $eventoPartidoRepo,
		AlineacionRepo $alineacionRepo, LigaRepo $ligaRepo, EstadioRepo $estadioRepo, EquipoRepo $equipoRepo, PlantillaRepo $plantillaRepo,
		PorteroRepo $porteroRepo, TablaAcumuladaRepo $tablaAcumuladaRepo, AnuncioRepo $anuncioRepo)
	{
		$this->posicionesRepo = $posicionesRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		$this->partidoRepo = $partidoRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->plantillaRepo = $plantillaRepo;
		$this->goleadorRepo = $goleadorRepo;
		$this->configuracionRepo = $configuracionRepo;
		$this->eventoPartidoRepo = $eventoPartidoRepo;
		$this->alineacionRepo = $alineacionRepo;
		$this->ligaRepo = $ligaRepo;
		$this->estadioRepo = $estadioRepo;
		$this->equipoRepo = $equipoRepo;
		$this->porteroRepo = $porteroRepo;
        $this->tablaAcumuladaRepo = $tablaAcumuladaRepo;
        $this->anuncioRepo = $anuncioRepo;

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
		header('Access-Control-Allow-Headers: Authorization,Content-Type');

	   	if("OPTIONS" == $_SERVER['REQUEST_METHOD']) {
		    http_response_code(200);
		    exit(0);
		}
	}

	public function campeonatos()
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.campeonatos', $minutos, function(){
			
			$campeonatos = $this->campeonatoRepo->getMostrarApp()->load('liga');
			$data['campeonatos'] = [];
			foreach($campeonatos as $campeonato)
			{
				$c['id'] = $campeonato->id;
				$c['nombre'] = $campeonato->nombre;
				$c['mostrar_calendario'] = $campeonato->menu_app_calendario==1?true:false;
				$c['mostrar_posiciones'] = $campeonato->menu_app_posiciones==1?true:false;
				$c['mostrar_tabla_acumulada'] = $campeonato->menu_app_tabla_acumulada==1?true:false;
				$c['mostrar_goleadores'] = $campeonato->menu_app_goleadores==1?true:false;
				$c['mostrar_porteros'] = $campeonato->menu_app_porteros==1?true:false;
				$c['mostrar_plantilla'] = $campeonato->menu_app_plantilla==1?true:false;
				$c['liga_id'] = $campeonato->liga_id;
				$c['liga'] = $campeonato->liga->nombre;
				$data['campeonatos'][] = $c;
			}
			return $data;
		});
		return json_encode($data);
	}

	public function posiciones($ligaId, $campeonatoId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.posiciones'.$ligaId.'-'.$campeonatoId, $minutos, function() use ($ligaId, $campeonatoId){
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
			$posicionesDB = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos);
			$data['posiciones'] = [];
			foreach($posicionesDB as $posicion)
			{
				$p['equipo'] = $posicion->equipo->nombre_corto;
				$p['logo_equipo'] = $posicion->equipo->logo;
				$p['POS'] = $posicion->POS;
				$p['JJ'] = $posicion->JJ;
				$p['JG'] = $posicion->JG;
				$p['JE'] = $posicion->JE;
				$p['JP'] = $posicion->JP;
				$p['GF'] = $posicion->GF;
				$p['GC'] = $posicion->GC;
				$p['DIF'] = $posicion->DIF;
				$p['PTS'] = $posicion->PTS;
				$data['posiciones'][] = $p;
			}
			//$data['campeonato'] = $campeonato;
			/*Anuncios*/
			$dataAnuncio = $this->anuncioRepo->getAnuncioForPantallaApp(3);
			$data['mostrar_anuncio'] = $dataAnuncio['mostrar_anuncio'];
			$data['anuncio'] = $this->getArrayAnuncio($dataAnuncio['anuncio']);
			return $data;
		});
		return json_encode($data);
	}

	public function acumulada($ligaId, $campeonatoId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.acumulada'.$ligaId.'-'.$campeonatoId, $minutos, function() use ($ligaId, $campeonatoId){
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
				$posicionesDB = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos, 1, $ta);
			}
			else
			{
				$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], [2,3]);
				$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
				$posicionesDB = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos, 1, $ta);
			}
			$data['posiciones'] = [];
			foreach($posicionesDB as $posicion)
			{
				$p['equipo'] = $posicion->equipo->nombre_corto;
				$p['logo_equipo'] = $posicion->equipo->logo;
				$p['POS'] = $posicion->POS;
				$p['JJ'] = $posicion->JJ;
				$p['JG'] = $posicion->JG;
				$p['JE'] = $posicion->JE;
				$p['JP'] = $posicion->JP;
				$p['GF'] = $posicion->GF;
				$p['GC'] = $posicion->GC;
				$p['DIF'] = $posicion->DIF;
				$p['PTS'] = $posicion->PTS;
				$data['posiciones'][] = $p;
			}
			/*Anuncios*/
			$dataAnuncio = $this->anuncioRepo->getAnuncioForPantallaApp(9);
			$data['mostrar_anuncio'] = $dataAnuncio['mostrar_anuncio'];
			$data['anuncio'] = $this->getArrayAnuncio($dataAnuncio['anuncio']);
			return $data;
		});
		return json_encode($data);
	}

	public function porteros($ligaId,$campeonatoId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.porteros'.$ligaId.'-'.$campeonatoId, $minutos, function() use ($ligaId, $campeonatoId){
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}
			$porterosDB = $this->porteroRepo->getPorteros($campeonato->id);

			foreach($porterosDB as $portero)
			{
				$portero->imagen_equipo = \Storage::disk(env('DISK'))->url($portero->imagen_equipo);
			}

			$data['porteros'] =[];
			foreach($porterosDB as $index => $portero)
			{
				$p['posicion'] = $index+1;
				$p['jugador'] = $portero->primerapellido." ".$portero->primernombre;
				$p['equipo'] = $portero->equipo;
				$p['logo_equipo'] = $portero->imagen_equipo;
				$p['goles'] = number_format($portero->goles,2);
				$p['partidos_jugados'] = number_format($portero->partidosJugados,0);
				$p['promedio'] = number_format($portero->promedio,1);

				$data['porteros'][] = $p;
			}
			//$data['campeonato'] = $campeonato;
			/*Anuncios*/
			$anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(5);
			$data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
			$data['anuncio'] = $anuncios['anuncio'];
			return $data;
		});
		return json_encode($data);
	}

	public function goleadores($ligaId,$campeonatoId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.goleadores'.$ligaId.'-'.$campeonatoId, $minutos, function() use ($ligaId, $campeonatoId){
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}
			$goleadores = $this->goleadorRepo->getGoleadores($campeonato);
			//$goleadores = array_slice($goleadores, 0, 10);
			$data['goleadores'] = [];
			foreach($goleadores as $index => $goleador)
			{
				$g['posicion'] = $index + 1;
				$g['jugador'] = $goleador->jugador->primer_apellido." ".$goleador->jugador->primer_nombre;
				$g['equipo'] = $goleador->equipo->nombre_corto;
				$g['logo_equipo'] = $goleador->equipo->logo;
				$g['goles'] = $goleador->goles;
				$g['minutos'] = $goleador->minutos;
				$data['goleadores'][] = $g;
			}

			//$data['campeonato'] = $campeonato;
			/*Anuncios*/
			$anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(4);
			$data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
			$data['anuncio'] = $anuncios['anuncio'];
			return $data;
		});
		return json_encode($data);
	}

	public function amarillas($ligaId,$campeonatoId)
	{
		$minutos = 0;
		$data = Cache::remember('apiV2.amarillas'.$ligaId.'-'.$campeonatoId, $minutos, function() use ($ligaId, $campeonatoId){
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}
			$eventos = $this->eventoPartidoRepo->getByCampeonato($campeonato->id, [10,11]);
			//$goleadores = array_slice($goleadores, 0, 10);
			$jugadoresDB = [];
			foreach($eventos as $evento)
			{
				if(!isset($jugadoresDB[$evento->jugador1_id]))
				{
					$jugadoresDB[$evento->jugador1_id]['posicion'] = 0;
					$jugadoresDB[$evento->jugador1_id]['jugador'] = $evento->jugador1->primer_apellido." ".$evento->jugador1->primer_nombre;
					$jugadoresDB[$evento->jugador1_id]['amarillas'] = 0;
					$jugadoresDB[$evento->jugador1_id]['equipo'] = $evento->equipo->nombre_corto;
					$jugadoresDB[$evento->jugador1_id]['logo_equipo'] = $evento->equipo->logo;
				}
				if($evento->evento_id == 10)
				{
					$jugadoresDB[$evento->jugador1_id]['amarillas']++;
				}
				else
				{
					if($evento->doble_amarilla) 
						$jugadoresDB[$evento->jugador1_id]['amarillas']--;
				}
			}
			usort($jugadoresDB, function($a, $b){
				if($a['amarillas'] == $b['amarillas']) return strcmp($a['jugador'],$b['jugador']);
				return ($a['amarillas'] < $b['amarillas']) ? 1 : -1;
			});
			$posicion = 1;
			$jugadores = [];
			foreach($jugadoresDB as $index => $jugador){
				$jugadoresDB[$index]['posicion'] = $posicion;
				if($posicion<=1000) $jugadores[] = $jugadoresDB[$index];
				$posicion++;
			}
			$data['jugadores'] = $jugadores;
			//$data['campeonato'] = $campeonato;
			/*Anuncios*/
			$anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(4);
			$data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
			$data['anuncio'] = $anuncios['anuncio'];
			return $data;
		});
		return json_encode($data);
	}

	public function rojas($ligaId,$campeonatoId)
	{
		$minutos = 0;
		$data = Cache::remember('apiV2.amarillas'.$ligaId.'-'.$campeonatoId, $minutos, function() use ($ligaId, $campeonatoId){
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}
			$eventos = $this->eventoPartidoRepo->getByCampeonato($campeonato->id, [11]);
			//$goleadores = array_slice($goleadores, 0, 10);
			$jugadoresDB = [];
			foreach($eventos as $evento)
			{
				if(!isset($jugadoresDB[$evento->jugador1_id]))
				{
					$jugadoresDB[$evento->jugador1_id]['posicion'] = 0;
					$jugadoresDB[$evento->jugador1_id]['jugador'] = $evento->jugador1->primer_apellido." ".$evento->jugador1->primer_nombre;
					$jugadoresDB[$evento->jugador1_id]['rojas'] = 0;
					$jugadoresDB[$evento->jugador1_id]['equipo'] = $evento->equipo->nombre_corto;
					$jugadoresDB[$evento->jugador1_id]['logo_equipo'] = $evento->equipo->logo;
				}
				$jugadoresDB[$evento->jugador1_id]['rojas']++;
			}
			usort($jugadoresDB, function($a, $b){
				if($a['rojas'] == $b['rojas']) return strcmp($a['jugador'],$b['jugador']);
				return ($a['rojas'] < $b['rojas']) ? 1 : -1;
			});
			$posicion = 1;
			$jugadores = [];
			foreach($jugadoresDB as $index => $jugador){
				$jugadoresDB[$index]['posicion'] = $posicion;
				if($posicion<=1000) $jugadores[] = $jugadoresDB[$index];
				$posicion++;
			}
			$data['jugadores'] = $jugadores;
			//$data['campeonato'] = $campeonato;
			/*Anuncios*/
			$anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(4);
			$data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
			$data['anuncio'] = $anuncios['anuncio'];
			return $data;
		});
		return json_encode($data);
	}

	public function jornadas($ligaId, $campeonatoId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.jornadas'.$ligaId.'-'.$campeonatoId, $minutos, function() use ($ligaId, $campeonatoId){
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}
			$partidos = $this->partidoRepo->getByCampeonato($campeonato->id);
			$data['jornadas'] = [];
			$jornadaActual = 0;
			$jornadaActualEncontrada = false;
			$jornadas = [];
			foreach($partidos as $partido)
			{
				$j['id'] = $partido->jornada->id;
				$j['nombre'] = $partido->jornada->nombre;
				$jornadas[$partido->jornada_id] = $j;

				if(date('Y-m-d',strtotime($partido->fecha)) == date('Y-m-d'))
				{
					$jornadaActual = $partido->jornada_id;
					$jornadaActualEncontrada = true;
				}
				if(!$jornadaActualEncontrada && $partido->estado == 1 && $jornadaActual == 0)
					$jornadaActual = $partido->jornada_id;
			}
			foreach($jornadas as $jornada)
			{
				$data['jornadas'][] = $jornada;
			}
			$data['jornada_actual'] = $jornadaActual;
			/*Anuncios*/
			$dataAnuncio = $this->anuncioRepo->getAnuncioForPantallaApp(2);
			$data['mostrar_anuncio'] = $dataAnuncio['mostrar_anuncio'];
			$data['anuncio'] = $this->getArrayAnuncio($dataAnuncio['anuncio']);
			return $data;
		});
		return json_encode($data);
	}

	public function partidosByJornada($ligaId, $campeonatoId, $jornadaId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.partidosByJornada'.$ligaId.'-'.$campeonatoId.'-'.$jornadaId, $minutos, function() use ($ligaId, $campeonatoId,$jornadaId){
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}
			$partidos = $this->partidoRepo->getByCampeonatoByJornada($campeonato->id, $jornadaId);
			$fechas = [];
			foreach($partidos as $partido)
			{
				$fecha = date('Ymd',strtotime($partido->fecha));
				$fechas[$fecha]['fecha'] = date('Y-m-d',strtotime($partido->fecha));

				$p = $this->getArrayPartido($partido);

				$fechas[$fecha]['partidos'][] = $p;
			}
			$data['fechas_partidos'] = [];
			foreach($fechas as $fecha)
			{
				$data['fechas_partidos'][] = $fecha;
			}
			return $data;
		});
		return json_encode($data);
	}

	public function partido($partidoId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.partido'.$partidoId, $minutos, function() use ($partidoId){

			$partido = $this->partidoRepo->find($partidoId);
			$p = $this->getArrayPartido($partido);
			$data['partido'] = $p;
			return $data;
		});
		return json_encode($data);
	}

	public function narracion($partidoId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.narracion'.$partidoId, $minutos, function() use ($partidoId){
				$partido = $this->partidoRepo->find($partidoId);
				$p = $this->getArrayPartido($partido);
				$data['partido'] = $p;
				$es = [];
				if($partido->estado_id != 1){

					$eventos = $this->eventoPartidoRepo->getEnVivo($partidoId)->load('jugador1','jugador2');

                    $i = 0;
                    $golesLocal = $partido->goles_local;
                    $golesVisita = $partido->goles_visita;
					foreach($eventos as $evento)
					{
                        $esGol = $evento->evento_id == 6 || $evento->evento_id == 7 || $evento->evento_id == 8;
						$es[$i]['evento_id'] = $evento->evento_id;
						$es[$i]['comentario'] = $evento->comentario;
						$es[$i]['minuto'] = $evento->minuto;
                        if($esGol){
							$es[$i]['equipo_local'] = $partido->equipo_local->nombre_corto;
							$es[$i]['logo_equipo_local'] = $partido->equipo_local->logo;
							$es[$i]['goles_equipo_local'] = $golesLocal;
							$es[$i]['equipo_visita'] = $partido->equipo_visita->nombre_corto;
							$es[$i]['logo_equipo_visita'] = $partido->equipo_visita->logo;
							$es[$i]['goles_equipo_visita'] = $golesVisita;
							$es[$i]['equipo_anota'] = $evento->equipo_id == $partido->equipo_local_id ? 'local' : 'visita';
                            if($evento->equipo_id == $partido->equipo_local_id)
                                $golesLocal--;
                            if($evento->equipo_id == $partido->equipo_visita_id)
                                $golesVisita--;
						}
						if($evento->evento_id == 9)//cambio
						{
							$es[$i]['jugador_entra'] = $evento->jugador1->nombre_completo ?? '';
							$es[$i]['jugador_sale'] = $evento->jugador2->nombre_completo ?? '';
						}
						if($evento->evento_id == 10 || $evento->evento_id == 11)
						{
							$es[$i]['jugador'] = $evento->jugador1->nombre_completo ?? '';
						}
						$i++;
					}
				}
				$data['eventos'] = $es;
				return $data;
		});

		return json_encode($data);
	}

	public function alineaciones($partidoId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.alineaciones'.$partidoId, $minutos, function() use ($partidoId){
				$partido = $this->partidoRepo->find($partidoId);
				$p = $this->getArrayPartido($partido);
				$data['partido'] = $p;

                $alineacionLocal = $this->alineacionRepo->getAlineacionByEstado($partidoId, $partido->equipo_local_id, 1);
                $suplentesLocal = $this->alineacionRepo->getAlineacionByEstado($partidoId, $partido->equipo_local_id, 0);
                $alineacionVisita = $this->alineacionRepo->getAlineacionByEstado($partidoId, $partido->equipo_visita_id, 1);
				$suplentesVisita = $this->alineacionRepo->getAlineacionByEstado($partidoId, $partido->equipo_visita_id, 0);
				$dtLocal = $this->alineacionRepo->getTecnico($partidoId, $partido->equipo_local_id);
                $dtVisita = $this->alineacionRepo->getTecnico($partidoId, $partido->equipo_visita_id);
                $alLocal = [];
                $supLocal = [];
                $alVisita = [];
                $supVisita = [];
				foreach($alineacionLocal as $al)
				{
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($al->persona->primer_nombre,0,1);
                    $jugador['jugador'] = $nombre . '. ' . $al->persona->primer_apellido;
					$alLocal[] = $jugador;
                }
                foreach($suplentesLocal as $sl)
				{
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($sl->persona->primer_nombre,0,1);
                    $jugador['jugador'] = $nombre . '. ' . $sl->persona->primer_apellido;
					$supLocal[] = $jugador;
                }
				foreach($alineacionVisita as $av)
				{
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($av->persona->primer_nombre,0,1);
                    $jugador['jugador'] = $nombre . '. ' . $av->persona->primer_apellido;
					$alVisita[] = $jugador;
                }
                foreach($suplentesVisita as $sv)
				{
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($sv->persona->primer_nombre,0,1);
                    $jugador['jugador'] = $nombre . '. ' . $sv->persona->primer_apellido;
                    $supVisita[] = $jugador;
				}
				$data['alineaciones_local'] = $alLocal;
                $data['suplentes_local'] = $supLocal;
                $data['alineaciones_visita'] = $alVisita;
                $data['suplentes_visita'] = $supVisita;
				$data['dt_local'] = '';
				$data['dt_visita'] = '';
				if(!is_null($dtLocal))  {
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($dtLocal->primer_nombre,0,1);
                    $data['dt_local'] = 'DT. ' . $nombre . '. ' . $dtLocal->primer_apellido;
				}
				if(!is_null($dtVisita)){
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($dtVisita->primer_nombre,0,1);
                    $data['dt_visita'] = 'DT. ' . $nombre . '. ' . $dtVisita->primer_apellido;
				}
                
                /*Anuncios*/
                $anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(6);
                $data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
                $data['anuncio'] = $anuncios['anuncio'];

				return $data;
		});

		return json_encode($data);
	}

	public function eventos($partidoId)
	{
		$minutos = 0;
		$data = Cache::remember('apiV2.eventos'.$partidoId, $minutos, function() use ($partidoId){

				$partido = $this->partidoRepo->find($partidoId);
				$p = $this->getArrayPartido($partido);
				$data['partido'] = $p;

				$data['eventos'] = [];
				if($partido->estado_id != 1)
				{
					$eventos = $this->eventoPartidoRepo->getByEventos($partidoId, array(6,7,8,9,10,11),'minuto','DESC');
					$eventos->load('jugador1','jugador2');
					foreach($eventos as $evento)
					{
						$e['evento_id'] = $evento->evento_id;
						$e['minuto'] = $evento->minuto;
						$e['equipo_evento'] = $evento->equipo_id == $partido->equipo_local_id ? 'local' : 'visita';
						if($evento->evento_id == 9){ //cambio
							mb_internal_encoding("UTF-8");
							$nombreEntra = mb_substr($evento->jugador1->primer_nombre,0,1);
							$e['jugador_entra'] = $nombreEntra . '. ' . $evento->jugador1->primer_apellido;
							$nombreSale = mb_substr($evento->jugador2->primer_nombre,0,1);
							$e['jugador_sale'] = $nombreSale . '. ' . $evento->jugador2->primer_apellido;
						}
						else{
							$nombre = mb_substr($evento->jugador1->primer_nombre,0,1);
							$e['jugador'] = $nombre . '. ' . $evento->jugador1->primer_apellido;
						}
						$data['eventos'][] = $e;
					}
				}
				return $data;
		});

		return json_encode($data);
	}

	public function equipos($ligaId, $campeonatoId)
	{
		$minutos = 1;
		$data = Cache::remember('apiV2.equipos'.$ligaId.'-'.$campeonatoId, $minutos, function() use ($ligaId, $campeonatoId){
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}
			$campeonatoEquipos = $this->campeonatoEquipoRepo->getEquiposByCampeonato($campeonato->id);
			$equipos = array();
			foreach($campeonatoEquipos as $ce)
			{
				$c['id'] = $ce->id;
				$c['nombre'] = $ce->nombre;
				$c['logo'] = $ce->logo;
				$equipos[] = $c;
			}
			$data['equipos']  = $equipos;
			return $data;
		});
		return json_encode($data);
	}

	public function plantilla($ligaId, $campeonatoId, $equipoId)
	{
		$minutos = 0;
		$data = Cache::remember('apiV2.plantilla'.$ligaId.'-'.$campeonatoId.'-'.$equipoId, $minutos, function() use ($ligaId, $campeonatoId, $equipoId){
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}
			$data['equipo'] = null;
			if($equipoId != 0){
				$equipoDB = $this->equipoRepo->find($equipoId);
				$equipo['id'] = $equipoDB->id;
				$equipo['nombre'] = $equipoDB->nombre;
				$equipo['logo'] = $equipoDB->logo;
				$data['equipo'] = $equipo;
			}
			$jugadores = $this->plantillaRepo->getPlantilla($campeonato, $equipoId);
			$plantilla = array();
			foreach($jugadores as $jugador)
			{
				$j = new stdClass();

				mb_internal_encoding("UTF-8");
				$string = $jugador->primer_nombre;
				$j->nombre = mb_substr($string,0,1) . '. '.$jugador->primer_apellido;
				$j->minutos_jugados = $jugador->minutos_jugados;
				$j->goles = $jugador->goles;
				$j->edad = $jugador->edad;
				$j->tarjetas_amarillas = $jugador->amarillas;
				$j->dobles_amarillas = $jugador->doblesamarillas;
				$j->tarjetas_rojas = $jugador->rojas;
				$plantilla[] = $j;
			}
			$data['plantilla'] = $plantilla;
			/*Anuncios*/
			$anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(8);
			$data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
			$data['anuncio'] = $anuncios['anuncio'];
			return $data;
		});
		return json_encode($data);
	}

	/*************************************/


	public function calendario($ligaId, $campeonatoId, $completo)
	{
		$minutos = 0;
		$data = Cache::remember('apiV2.calendario'.$ligaId.'-'.$campeonatoId.'-'.$completo, $minutos, function() use ($ligaId, $campeonatoId, $completo){
			if($campeonatoId == 0)
			{
				$campeonato = $this->campeonatoRepo->getActual($ligaId);
			}
			else
			{
				$campeonato = $this->campeonatoRepo->find($campeonatoId);
			}

			if($completo == 0){
				$configuracion = $this->configuracionRepo->find(1);
				$diasInicio = $configuracion->parametro1;
				$diasFin = $configuracion->parametro2;

				$fechaInicio = $this->getFecha($diasInicio . ' day');
				$fechaFin = $this->getFecha($diasFin . ' day');

				//$fechaInicio = $this->getFecha($configuracion->parametro1) . ' 00:00:00';
				//$fechaFin = $this->getFecha($configuracion->parametro2) . ' 23:59:59';
				$partidos = $this->partidoRepo->getByCampeonatoByFechas($campeonato->id, $fechaInicio, $fechaFin);
			}
			else
				$partidos = $this->partidoRepo->getByCampeonato($campeonato->id);

			$jornadas = array();
			foreach($partidos as $partido){

				$jornadas[$partido->jornada_id]['jornada'] = $partido->jornada->nombre;

				$p = new \App\App\Entities\Partido;
				$p->id = $partido->id;
				$p->equipo_local = $this->getObjetoEquipo($partido->equipo_local);
				$p->equipo_visita = $this->getObjetoEquipo($partido->equipo_visita);
				$p->goles_local = $partido->goles_local;
				$p->goles_visita = $partido->goles_visita;
				$p->fecha_real = $partido->fecha;
				$p->fecha = date('d/m',strtotime($partido->fecha));
				$p->hora = date('H:i',strtotime($partido->fecha));
				$p->estadio = $partido->estadio->nombre;
				$p->estado = $partido->descripcion_estado;
				$p->estado_real = $partido->estado;

				$jornadas[$partido->jornada_id]['partidos'][] = $p;
			}
			//$data['jornadas'] = $jornadas;

			$j = array();
			foreach($jornadas as $jornada)
			{
				$jj = new stdClass();
				$jj->jornada = $jornada['jornada'];
				$jj->partidos = $jornada['partidos'];
				$j[] = $jj;
			}
			
			$data['jornadas'] = $j;
			//encontrando jornada actual
			$jornadaActual = 0;
			foreach($j as $index => $value)
			{
				$jornadaEncontrada = false;
				foreach($value->partidos as $partido)
				{
					$fechaPartido = date('Y-m-d', strtotime($partido->fecha_real));
					$hoy = date('Y-m-d');
					if($partido->estado_real == 2 || $partido->estado_real == 3) $jornadaActual = $index;
					if($fechaPartido == $hoy) { $jornadaActual = $index; $jornadaEncontrada = true; }
				}
				if($jornadaEncontrada) break;
			}


			$c = new \App\App\Entities\Campeonato;
			$c->id = $campeonato->id;
			$c->nombre = $campeonato->nombre;
			$data['campeonato'] = $c;
			/*Anuncios*/
			$anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(2);
			$data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
			$data['anuncio'] = $anuncios['anuncio'];
			$data['jornada_actual'] = $jornadaActual;

			return $data;
		});
		return json_encode($data);
	}

	public function campeonatosApp()
	{
		$minutos = 1;
		$data = Cache::remember('rest.campeonatosApp', $minutos, function(){
				$campeonatosDB = $this->campeonatoRepo->getMostrarApp();
				$campeonatos = array();

				$ligas = array();
				$i = 0;
				$liga = '';
				$campeonatosByLiga = array();
				$newkey = 0;
				foreach($campeonatosDB as $campeonato){

					if($liga == '')
					{
						$campeonatosByLiga[] = $campeonato;
						$liga = $campeonato->liga;
					}
					else
					{
						if($liga != $campeonato->liga){
							$ligas[$i]['liga'] = $liga;
							$ligas[$i]['campeonatos'] = $campeonatosByLiga;
							$i++;
							$liga = $campeonato->liga;
							$campeonatosByLiga = array();
							$campeonatosByLiga[] = $campeonato;
						}
						else
						{
							$liga = $campeonato->liga;
							$campeonatosByLiga[] = $campeonato;
						}
					}
				}
				$ligas[$i]['liga'] = $liga;
				$ligas[$i]['campeonatos'] = $campeonatosByLiga;

				$data['ligas'] = $ligas;
				return $data;
		});

		$ligas = $data['ligas'];
		return json_encode($ligas);
	}

	function getFecha($extraDays){
		$fecha = date('Y-m-d');
		$nuevafecha = strtotime ( $extraDays , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		return $nuevafecha;
	}

	public function getObjetoEquipo($equipo)
	{
		$e = new stdClass();
		$e->id = $equipo->id;
		$e->nombre = $equipo->nombre;
		$e->nombre_corto = $equipo->nombre_corto;
		$e->logo = $equipo->logo;
		return $e;
	}

	public function getArrayPartido($partido)
	{
		$p['id'] = $partido->id;
		$p['hora'] = date('H:i',strtotime($partido->fecha));
		$p['equipo_local'] = $partido->equipo_local->nombre_corto;
		$p['logo_equipo_local'] = $partido->equipo_local->logo;
		$p['goles_equipo_local'] = $partido->goles_local ?? 0;
		$p['equipo_visita'] = $partido->equipo_visita->nombre_corto;
		$p['logo_equipo_visita'] = $partido->equipo_visita->logo;
		$p['goles_equipo_visita'] = $partido->goles_visita ?? 0;
		$p['estado'] = $partido->estado;
		return $p;
	}

	public function getArrayAnuncio($anuncio)
	{
		if(is_null($anuncio)) return null;

		$ad['anunciante'] = $anuncio->anunciante;
		$ad['nombre_anunciante'] = $anuncio->nombre_anunciante;
		$ad['tipo'] = $anuncio->tipo;
		$ad['segundos_mostrandose'] = $anuncio->segundos_mostrandose;
		$ad['minutos_espera'] = $anuncio->minutos_espera;
		if(!is_null($anuncio->link)) $ad['link'] = $anuncio->link;
		if(!is_null($anuncio->imagen)) $ad['imagen'] = $anuncio->imagen;
		return $ad;
	}


}
