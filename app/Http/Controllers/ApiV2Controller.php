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
			$anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(3);
			$data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
			$data['anuncio'] = $anuncios['anuncio'];
			return $data;
		});
		return json_encode($data);
	}

	public function acumulada($ligaId, $campeonatoId)
	{
		$minutos = 0;
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
                $anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(9);
                $data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
                $data['anuncio'] = $anuncios['anuncio'];
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
				$portero->imagen_equipo = \Storage::disk('public')->url($portero->imagen_equipo);
			}

			$data['porteros'] =[];
			foreach($porterosDB as $index => $portero)
			{
				$p['posicion'] = $index+1;
				$p['jugador'] = $portero->primerapellido." ".$portero->primernombre;
				$p['equipo'] = $portero->equipo;
				$p['logo_equipo'] = $portero->imagen_equipo;
				$p['goles'] = $portero->goles;
				$p['partidos_jugados'] = $portero->partidosJugados;
				$p['promedio'] = $portero->promedio;

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

	public function plantilla($ligaId, $campeonatoId, $equipoId)
	{
		$minutos = 1;
		$data = Cache::remember('rest.plantilla'.$ligaId.'-'.$campeonatoId.'-'.$equipoId, $minutos, function() use ($ligaId, $campeonatoId, $equipoId){
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
				$jugadores = $this->plantillaRepo->getPlantilla($campeonato, $equipoId);
				$plantilla = array();
				foreach($jugadores as $jugador)
				{
					$j = new stdClass();

					mb_internal_encoding("UTF-8");
					$string = $jugador->primer_nombre;
					$j->primer_nombre = mb_substr($string,0,1) . '.';

					//$j->primer_nombre = $jugador->persona->primer_nombre;

					/*mb_internal_encoding("UTF-8");
					$string = $jugador->persona->primer_apellido;
					$j->primer_apellido = mb_substr($string,0,1);*/

					$j->primer_apellido = $jugador->primer_apellido;
					$j->mj = $jugador->minutos_jugados;
					$j->goles = $jugador->goles;
					$j->edad = $jugador->edad;
					$plantilla[] = $j;
				}


				$data['plantilla'] = $plantilla;

				$c = new \App\App\Entities\Campeonato;
				$c->id = $campeonato->id;
				$c->nombre = $campeonato->nombre;
				$data['campeonato'] = $c;

                $data['equipo'] = $equipo;
                /*Anuncios*/
                $anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(8);
                $data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
                $data['anuncio'] = $anuncios['anuncio'];
				return $data;
		});


		return json_encode($data);
	}

	public function equipos($ligaId, $campeonatoId)
	{
		$minutos = 1;
		$data = Cache::remember('rest.equipos'.$ligaId.'-'.$campeonatoId, $minutos, function() use ($ligaId, $campeonatoId){
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
					$equipos[] = $ce;
				}
				$data['equipos']  = $equipos;

				$c = new \App\App\Entities\Campeonato;
				$c->id = $campeonato->id;
				$c->nombre = $campeonato->nombre;
                $data['campeonato'] = $c;
                /*Anuncios*/
                $anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(7);
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
			$jornadas = [];
			foreach($partidos as $partido)
			{
				$j['id'] = $partido->jornada->id;
				$j['nombre'] = $partido->jornada->nombre;
				$jornadas[$partido->jornada_id] = $j;
			}
			foreach($jornadas as $jornada)
			{
				$data['jornadas'][] = $jornada;
			}
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

				$p['id'] = $partido->id;
				$p['hora'] = date('H:i',strtotime($partido->fecha));
				$p['equipo_local'] = $partido->equipo_local->nombre_corto;
				$p['logo_equipo_local'] = $partido->equipo_local->logo;
				$p['goles_equipo_local'] = $partido->goles_local;
				$p['equipo_visita'] = $partido->equipo_visita->nombre_corto;
				$p['logo_equipo_visita'] = $partido->equipo_visita->logo;
				$p['goles_equipo_visita'] = $partido->goles_visita;
				$p['estado'] = $partido->estado;

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

	public function eventos($partidoId)
	{
		$minutos = 1;
		$data = Cache::remember('rest.eventos'.$partidoId, $minutos, function() use ($partidoId){

				$partido = $this->partidoRepo->find($partidoId);

				$es = [];
				if($partido->estado_id != 1){

					$eventos = $this->eventoPartidoRepo->getByEventos($partidoId, array(6,7,8,10,11));

					$i = 0;
					$golesLocal = 0;
					$golesVisita = 0;
					foreach($eventos as $evento)
					{
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
							mb_internal_encoding("UTF-8");
							$nombre = mb_substr($evento->jugador1->primer_nombre,0,1);
							$es[$i]['nombre_local'] = $nombre . '. ' . $evento->jugador1->primer_apellido;
							$es[$i]['imagen_local'] = $evento->evento->imagen;
						}
						else{
							$es[$i]['minuto_visita'] = $evento->minuto;
							mb_internal_encoding("UTF-8");
							$nombre = mb_substr($evento->jugador1->primer_nombre,0,1);
							$es[$i]['nombre_visita'] = $nombre . '. ' . $evento->jugador1->primer_apellido;
							$es[$i]['imagen_visita'] = $evento->evento->imagen;
						}

						$i++;
					}
				}
				$data['eventos'] = $es;

				$p = new \App\App\Entities\Partido;
				$p->id = $partido->id;
				$p->equipo_local = $partido->equipo_local;
				$p->equipo_visita = $partido->equipo_visita;
				$p->goles_local = $partido->goles_local;
				$p->goles_visita = $partido->goles_visita;
				$partido->fecha = strtotime($partido->fecha);
				$p->fecha = date('d/m',$partido->fecha);
				$p->hora = date('H:i',$partido->fecha);
				$p->estadio = $partido->estadio->nombre;
				$p->estado = $partido->descripcion_estado;
				$p->minuto_jugado = $partido->tiempo;
				if($p->minuto_jugado == 'P') $p->minuto_jugado = date('d/m H:i',$partido->fecha);

				$data['partido'] = $p;

				return $data;
		});

		return json_encode($data);
	}

	public function enVivo($partidoId)
	{
		$minutos = 1;
		$data = Cache::remember('rest.enVivo'.$partidoId, $minutos, function() use ($partidoId){
				$partido = $this->partidoRepo->find($partidoId);
				$es = [];
				if($partido->estado_id != 1){

					$eventos = $this->eventoPartidoRepo->getEnVivo($partidoId);

                    $i = 0;
                    $golesLocal = $partido->goles_local;
                    $golesVisita = $partido->goles_visita;
					foreach($eventos as $evento)
					{
                        $esGol = $evento->evento_id == 6 || $evento->evento_id == 7 || $evento->evento_id == 8;
						$es[$i]['comentario'] = $evento->comentario;
						$es[$i]['minuto'] = $evento->minuto;
                        $es[$i]['imagen'] = $evento->evento->imagen;
                        $es[$i]['evento_id'] = $evento->evento_id;
                        $es[$i]['es_gol'] = $esGol;
                        $es[$i]['goles_local'] = $golesLocal;
                        $es[$i]['goles_visita'] = $golesVisita;
                        $es[$i]['equipo_anota'] = $evento->equipo_id == $partido->equipo_local_id ? 'local' : 'visita';
                        if($esGol){
                            if($evento->equipo_id == $partido->equipo_local_id)
                                $golesLocal--;
                            if($evento->equipo_id == $partido->equipo_visita_id)
                                $golesVisita--;
                        }
						$i++;
					}
				}
				$data['eventos'] = $es;

				$p = new \App\App\Entities\Partido;
				$p->id = $partido->id;
				$p->equipo_local = $partido->equipo_local;
				$p->equipo_visita = $partido->equipo_visita;
				$p->goles_local = $partido->goles_local;
				$p->goles_visita = $partido->goles_visita;
				$partido->fecha = strtotime($partido->fecha);
				$p->fecha = date('d/m',$partido->fecha);
				$p->hora = date('H:i',$partido->fecha);
				$p->estadio = $partido->estadio->nombre;
				$p->estado = $partido->descripcion_estado;
				$p->minuto_jugado = $partido->tiempo;
				if($p->minuto_jugado == 'P') $p->minuto_jugado = date('d/m H:i',$partido->fecha);

				$data['partido'] = $p;

				return $data;
		});

		return json_encode($data);
	}

	public function alineaciones($partidoId)
	{
		$minutos = 1;
		$data = Cache::remember('rest.alineaciones'.$partidoId, $minutos, function() use ($partidoId){
				$partido = $this->partidoRepo->find($partidoId);
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
                    $jugador['nombre'] = $nombre . '. ' . $al->persona->primer_apellido;
                    $jugador['nombre_completo'] = $al->persona->nombre_completo_apellidos;
					$jugador['es_titular'] = $al->es_titular;

					$alLocal[] = $jugador;
                }
                foreach($suplentesLocal as $sl)
				{
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($sl->persona->primer_nombre,0,1);
                    $jugador['nombre'] = $nombre . '. ' . $sl->persona->primer_apellido;
                    $jugador['nombre_completo'] = $sl->persona->nombre_completo_apellidos;
					$jugador['es_titular'] = $sl->es_titular;

					$supLocal[] = $jugador;
                }
				foreach($alineacionVisita as $av)
				{
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($av->persona->primer_nombre,0,1);
                    $jugador['nombre'] = $nombre . '. ' . $av->persona->primer_apellido;
                    $jugador['nombre_completo'] = $av->persona->nombre_completo_apellidos;
					$jugador['es_titular'] = $av->es_titular;

					$alVisita[] = $jugador;
                }
                foreach($suplentesVisita as $sv)
				{
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($sv->persona->primer_nombre,0,1);
                    $jugador['nombre'] = $nombre . '. ' . $sv->persona->primer_apellido;
                    $jugador['nombre_completo'] = $sv->persona->nombre_completo_apellidos;
                    $jugador['es_titular'] = $sv->es_titular;
                    $supVisita[] = $jugador;
                }
                $data['alineacionVisita'] = $alVisita;
                $data['suplentesVisita'] = $supVisita;
                $data['alineacionLocal'] = $alLocal;
                $data['suplentesLocal'] = $supLocal;
				$data['dtLocal'] = [];
				$data['dtVisita'] = [];
				if(!is_null($dtLocal))  {
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($dtLocal->primer_nombre,0,1);
                    $data['dtLocal']['nombre'] = $nombre . '. ' . $dtLocal->primer_apellido;
                    $data['dtLocal']['nombre_completo'] = $dtLocal->nombre_completo_apellidos;
				}
				if(!is_null($dtVisita)){
					mb_internal_encoding("UTF-8");
					$nombre = mb_substr($dtVisita->primer_nombre,0,1);
                    $data['dtVisita']['nombre'] = $nombre . '. ' . $dtVisita->primer_apellido;
                    $data['dtVisita']['nombre_completo'] = $dtVisita->nombre_completo_apellidos;
				}

				//* SUSTITUCIONES *///
				$sustitucionesLocal = [];
				$sustitucionesVisita = [];
				$eventosLocal = $this->eventoPartidoRepo->getByEventosByEquipo($partidoId, array(9), $partido->equipo_local_id);
				$eventosVisita = $this->eventoPartidoRepo->getByEventosByEquipo($partidoId, array(9), $partido->equipo_visita_id);
				foreach($eventosLocal as $el)
				{
					mb_internal_encoding("UTF-8");
					$nombreEntra = mb_substr($el->jugador1->primer_nombre,0,1);
                    $s['entra_nombre'] = $nombreEntra . '. ' . $el->jugador1->primer_apellido;
                    $s['entra_nombre_completo'] = $el->jugador1->nombre_completo_apellidos;
					$nombreSale = mb_substr($el->jugador2->primer_nombre,0,1);
                    $s['sale_nombre'] = $nombreSale . '. ' .$el->jugador2->primer_apellido;
                    $s['sale_nombre_completo'] = $el->jugador2->nombre_completo_apellidos;
					$s['minuto'] = $el->minuto;
					$sustitucionesLocal[] = $s;
				}

				foreach($eventosVisita as $ev)
				{
					mb_internal_encoding("UTF-8");
					$nombreEntra = mb_substr($ev->jugador1->primer_nombre,0,1);
                    $s['entra_nombre'] = $nombreEntra . '. ' . $ev->jugador1->primer_apellido;
                    $s['entra_nombre_completo'] = $ev->jugador1->nombre_completo_apellidos;
					$nombreSale = mb_substr($ev->jugador2->primer_nombre,0,1);
                    $s['sale_nombre'] = $nombreSale . '. ' .$ev->jugador2->primer_apellido;
                    $s['sale_nombre_completo'] = $ev->jugador2->nombre_completo_apellidos;
					$s['minuto'] = $ev->minuto;
					$sustitucionesVisita[] = $s;
				}

				$data['sustitucionesLocal'] = $sustitucionesLocal;
				$data['sustitucionesVisita'] = $sustitucionesVisita;

				$p = new \App\App\Entities\Partido;
				$p->id = $partido->id;
				$p->equipo_local = $partido->equipo_local;
				$p->equipo_visita = $partido->equipo_visita;
				$p->goles_local = $partido->goles_local;
				$p->goles_visita = $partido->goles_visita;
				$partido->fecha = strtotime($partido->fecha);
				$p->fecha = date('d/m',$partido->fecha);
				$p->hora = date('H:i',$partido->fecha);
				$p->estadio = $partido->estadio->nombre;
				$p->estado = $partido->descripcion_estado;
				$p->minuto_jugado = $partido->tiempo;
				if($p->minuto_jugado == 'P') $p->minuto_jugado = date('d/m H:i',$partido->fecha);

                $data['partido'] = $p;
                
                /*Anuncios*/
                $anuncios = $this->anuncioRepo->getAnuncioForPantallaApp(6);
                $data['mostrar_anuncio'] = $anuncios['mostrar_anuncio'];
                $data['anuncio'] = $anuncios['anuncio'];

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

	function wordpressPosts($page)
	{
		$url = 'https://www.guatefutbol.com/wp-json/wp/v2/posts?page='.$page;
		//$url = 'https://www.futsal502.com/wp-json/wp/v2/posts?page='.$page;
		try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            $exe  = curl_exec($ch);
			
			curl_close($ch);
			
			$json = json_decode($exe);
			$articulos = [];
			foreach($json as $j)
			{
				$a['id'] = $j->id;
				//$a['jetpack_featured_media_url'] = $j->jetpack_featured_media_url;
				try{
					$url = str_replace('\/','/',$j->jetpack_featured_media_url);
					//$imagen = $this->getImage($j->id,$url);
					//$a['jetpack_featured_media_url'] = \Storage::disk('public')->url($imagen);
					$a['image'] = $j->jetpack_featured_media_url;
					$a['jetpack_featured_media_url'] = $url;
				}
				catch(\Exception $ex)
				{
					$a['jetpack_featured_media_url'] = asset('assets/imagenes/fondo_noticias.png');
					$a['image'] = asset('assets/imagenes/fondo_noticias.png');
				}
				$a['link'] = $j->link;
				$a['titulo'] = $j->title->rendered;
				$a['title']['rendered'] = $j->title->rendered;
				$a['date'] = $j->date;
				$articulos[] = $a;
			}
			return $articulos;
        }
        catch(\Exception $ex)
        {
            return ['resultado' =>false, 'mensaje'=>'No se pudo obtener los servicios.','datos'=>['excepcion'=>$ex->getMessage()]];
        }
	}

	function getImage($id, $url)
	{
		$info = pathinfo($url);
		//dd($info);
		$name = 'noticias/'.$id.'.'.$info['extension'];
		if(file_exists($name)) return $name;
		$contents = file_get_contents($url);
		\Storage::disk('public')->put($name, $contents);
		return $name;
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


}
