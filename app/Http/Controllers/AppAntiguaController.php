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

use App\App\ExtraEntities\FichaPartido;

use View;
use stdClass;

class AppAntiguaController extends BaseController {

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

	public function __construct(PosicionesRepo $posicionesRepo, ConfiguracionRepo $configuracionRepo, CampeonatoRepo $campeonatoRepo, 
		PartidoRepo $partidoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, GoleadorRepo $goleadorRepo, EventoPartidoRepo $eventoPartidoRepo,AlineacionRepo $alineacionRepo, LigaRepo $ligaRepo, EstadioRepo $estadioRepo, EquipoRepo $equipoRepo, PlantillaRepo $plantillaRepo,PorteroRepo $porteroRepo, TablaAcumuladaRepo $tablaAcumuladaRepo)
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

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
		header('Access-Control-Allow-Headers: Authorization,Content-Type');

	   	if("OPTIONS" == $_SERVER['REQUEST_METHOD']) {
		    http_response_code(200);
		    exit(0);
		}
	}

	public function inicio($ligaId)
	{
		$campeonato = $this->campeonatoRepo->getActual($ligaId);
				
		$c = new \App\App\Entities\Campeonato;
		$c->id = $campeonato->id;
		$c->nombre = $campeonato->nombre;
		$c->liga = $campeonato->liga_id;
		$c->fechaInicio = $campeonato->fecha_inicio;
		$c->fechaFin = $campeonato->fecha_fin;
		$c->hashtag = $campeonato->hashtag;
		$c->visible = 1;
		$data['campeonato'] = $c;

		$campeonatosDB = $this->campeonatoRepo->getByLiga($ligaId)->toArray();
		$campeonatosDB = array_slice($campeonatosDB, 0, 5); 
		$campeonatos = [];
		foreach($campeonatosDB as $cam)
		{
			$c = new \App\App\Entities\Campeonato;
			$c->id = $cam['id'];
			$c->nombre = $cam['nombre'];
			$c->liga = $cam['liga_id'];
			$c->fechaInicio = $cam['fecha_inicio'];
			$c->fechaFin = $cam['fecha_fin'];
			$c->hashtag = $cam['hashtag'];
			$c->visible = 1;
			$campeonatos[] = $c;
		}
		$data['campeonatos'] = $campeonatos;

		$configDB = $this->configuracionRepo->find(6);
		$config['id'] = $configDB->id;
		$config['nombre'] = $configDB->nombre;	
		$config['parametro1'] = $configDB->parametro1;
		$config['parametro2'] = $configDB->parametro2;
		$config['parametro3'] = $configDB->parametro3;
		$data['refresh'] = $config;

		$data['calendario'] = $this->getCalendario($campeonato->id,0);

		return json_encode($data);
	}

	public function posiciones($campeonatoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual(21);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, 2, [2,3]);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		$posicionesDB = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos);
		$posiciones = [];
		foreach($posicionesDB as $pos)
		{
			$posicion['id'] = $pos->equipo->id;
			$posicion['POS'] = $pos->POS;
			$posicion['nombre'] = $pos->equipo->nombre;
			$posicion['ruta'] = 'imagenes/equipos/'.$pos->equipo->imagen;
			$posicion['PTS'] = $pos->PTS;
			$posicion['JJ'] = $pos->JJ;
			$posicion['JG'] = $pos->JG;
			$posicion['JE'] = $pos->JE;
			$posicion['JP'] = $pos->JP;			
			$posicion['DIF'] = $pos->DIF;
			$posicion['GF'] = $pos->GF;
			$posicion['GV'] = $pos->GC;

			$posiciones[] = $posicion;

		}

		$data['posiciones'] = $posiciones;
		return json_encode($posiciones);
	}

	public function porteros($campeonatoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual(21);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$porteros = $this->porteroRepo->getPorteros($campeonato->id);

		return json_encode($porteros);
	}

	public function goleadores($campeonatoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual(21);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$goleadoresDB = $this->goleadorRepo->getGoleadores($campeonato);
		$goleadoresDB = array_slice($goleadoresDB, 0, 10); 

		foreach($goleadoresDB as $goleador)
		{
			$g['id'] = $goleador->jugador->id;
			$g['primerapellido'] = $goleador->jugador->primer_apellido;
			$g['primernombre'] = $goleador->jugador->primer_nombre;			
			$g['goles'] = $goleador->goles;
			$g['minutos'] = $goleador->minutos;
			$g['edad'] = $goleador->jugador->fecha_nacimiento;
			$g['equipo'] = $goleador->equipo->nombre;
			$goleadores[] = $g;
		}

		return json_encode($goleadores);
	}

	public function plantilla($campeonatoId, $equipoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual(21);
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
			$j->id = $jugador->id;
			$j->primerapellido = $jugador->primer_apellido;
			$j->primernombre = $jugador->primer_nombre;
			$j->portero = $jugador->portero; 
			$j->edad = $jugador->edad;
			$j->minutosJugados = $jugador->minutos_jugados;
			$j->goles = $jugador->goles;
			$plantilla[] = $j;
		}

		$e = new \App\App\Entities\Equipo;
		$e->id = $equipo->id;
		$e->nombre = $equipo->nombre;
		$e->ruta = 'imagenes/equipos/'.$equipo->imagen;
		$data['equipo'] = $e;

		$data['plantilla'] = $plantilla;

		return json_encode($data);
	}

	public function equipos($campeonatoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual(21);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$campeonatoEquipos = $this->campeonatoEquipoRepo->getEquiposByCampeonato($campeonato->id);
		$equipos = array();
		foreach($campeonatoEquipos as $ce)
		{
			$e['id'] = $ce->id;
			$e['nombre'] = $ce->nombre;
			$e['ruta'] = 'imagenes/equipos/'.$ce->imagen;
			$equipos[] = $e;
		}
		return json_encode($equipos);

	}

	public function calendario($campeonatoId, $completo)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual(21);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$j = $this->getCalendario($campeonatoId, $completo);		
		return json_encode($j);
	}

	public function eventos($partidoId)
	{
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
					$es[$i]['nombre_local'] = $evento->jugador1->primer_nombre . ' ' . $evento->jugador1->primer_apellido;
					$es[$i]['imagen_local'] = $evento->imagen->ruta;
				}
				else{
					$es[$i]['minuto_visita'] = $evento->minuto;
					$es[$i]['nombre_visita'] = $evento->jugador1->primer_nombre . ' ' . $evento->jugador1->primer_apellido;
					$es[$i]['imagen_visita'] = $evento->imagen->ruta;
				}
				
				$i++;
			}
		}
		$data['eventos'] = $es;

		$p = new \App\App\Entities\Partido;
		$p->id = $partido->id;
		$p->equipoLocal = $partido->equipoLocal->nombre;
		$p->equipoVisita = $partido->equipoVisita->nombre;
		$p->golesLocal = $partido->goles_local;
		$p->golesVisita = $partido->goles_visita;
		$partido->fecha = strtotime($partido->fecha);
		$p->fecha = date('d/m',$partido->fecha);
		$p->hora = date('H:ia',$partido->fecha);
		$p->estadio = $partido->estadio->nombre;
		$p->estado = $partido->estado->nombre;

		$data['partido'] = $p;

		return json_encode($data);
	}

	public function enVivo($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$es = [];
		if($partido->estado_id != 1){

			$eventos = $this->eventoPartidoRepo->getByPartido($partidoId);
		
			$i = 0;
			foreach($eventos as $evento)
			{
				$es[$i]['comentario'] = $evento->comentario;
				$es[$i]['minuto'] = $evento->minuto;
				$es[$i]['imagen'] = $evento->imagen->ruta;
				$i++;
			}
		}
		$data['eventos'] = $es;

		$p = new \App\App\Entities\Partido;
		$p->id = $partido->id;
		$p->equipoLocal = $partido->equipoLocal->nombre;
		$p->equipoVisita = $partido->equipoVisita->nombre;
		$p->golesLocal = $partido->goles_local;
		$p->golesVisita = $partido->goles_visita;
		$partido->fecha = strtotime($partido->fecha);
		$p->fecha = date('d/m',$partido->fecha);
		$p->hora = date('H:ia',$partido->fecha);
		$p->estadio = $partido->estadio->nombre;
		$p->estado = $partido->estado->nombre;

		$data['partido'] = $p;
		
		return json_encode($data);
	}

	public function alineaciones($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$alineacionLocal = $this->alineacionRepo->getAlineacionByEstado($partidoId, $partido->equipo_local_id, true);
		$alineacionVisita = $this->alineacionRepo->getAlineacionByEstado($partidoId, $partido->equipo_visita_id, true);
		$dtLocal = $this->alineacionRepo->getTecnico($partidoId, $partido->equipo_local_id);
		$dtVisita = $this->alineacionRepo->getTecnico($partidoId, $partido->equipo_visita_id);

		$alLocal = [];
		$alVisita = [];
		foreach($alineacionLocal as $al)
		{
			$jugador['nombre'] = $al->persona->primer_nombre . ' ' . $al->persona->primer_apellido;
			$jugador['es_titular'] = $al->es_titular;

			$alLocal[] = $jugador;
		}
		foreach($alineacionVisita as $av)
		{
			$jugador['nombre'] = $av->persona->primer_nombre . ' ' . $av->persona->primer_apellido;
			$jugador['es_titular'] = $av->es_titular;

			$alVisita[] = $jugador;
		}
		$data['alineacionVisita'] = $alVisita;
		$data['alineacionLocal'] = $alLocal;

		$data['dtLocal'] = [];
		$data['dtVisita'] = [];
		if(!is_null($dtLocal))  $data['dtLocal']['nombre'] = $dtLocal->primer_nombre . ' ' . $dtLocal->primer_apellido;
		if(!is_null($dtVisita))  $data['dtVisita']['nombre'] = $dtVisita->primer_nombre . ' ' . $dtVisita->primer_apellido;

		//* SUSTITUCIONES *///
		$sustitucionesLocal = [];
		$sustitucionesVisita = [];
		$eventosLocal = $this->eventoPartidoRepo->getByEventosByEquipo($partidoId, array(9), $partido->equipo_local_id);
		$eventosVisita = $this->eventoPartidoRepo->getByEventosByEquipo($partidoId, array(9), $partido->equipo_visita_id);
		foreach($eventosLocal as $el)
		{
			$s['entra_nombre'] = $el->jugador1->primer_nombre . ' ' . $el->jugador1->primer_apellido;
			$s['sale_nombre'] = $el->jugador2->primer_nombre . ' ' .$el->jugador2->primer_apellido;
			$s['minuto'] = $el->minuto;
			$sustitucionesLocal[] = $s;
		}

		foreach($eventosVisita as $ev)
		{
			$s['entra_nombre'] = $ev->jugador1->primer_nombre . ' ' . $ev->jugador1->primer_apellido;
			$s['sale_nombre'] = $ev->jugador2->primer_nombre . ' ' . $ev->jugador2->primer_apellido;
			$s['minuto'] = $ev->minuto;
			$sustitucionesVisita[] = $s;
		}

		$data['sustitucionesLocal'] = $sustitucionesLocal;
		$data['sustitucionesVisita'] = $sustitucionesVisita;

		$p = new \App\App\Entities\Partido;
		$p->id = $partido->id;
		$p->equipoLocal = $partido->equipoLocal->nombre;
		$p->equipoVisita = $partido->equipoVisita->nombre;
		$p->imagenLocal = $partido->equipoLocal->imagen;
		$p->imagenVisita = $partido->equipoVisita->imagen;
		$p->golesLocal = $partido->goles_local;
		$p->golesVisita = $partido->goles_visita;
		$partido->fecha = strtotime($partido->fecha);
		$p->fecha = date('d/m',$partido->fecha);
		$p->hora = date('H:ia',$partido->fecha);
		$p->estadio = $partido->estadio->nombre;
		$p->estado = $partido->estado->nombre;

		$data['partido'] = $p;
		
		return json_encode($data);
	}

	public function acumulada($campeonatoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual(21);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$ta = $this->tablaAcumuladaRepo->getByCampeonato($campeonato->id);
		if(count($ta) > 0)
		{
			$partidosC1 = $this->partidoRepo->getByCampeonatoByFaseByEstado($ta[0]->campeonato1_id, 2, [2,3]);
			$partidosC2 = $this->partidoRepo->getByCampeonatoByFaseByEstado($ta[0]->campeonato2_id, 2, [2,3]);
			$partidos = $partidosC1->merge($partidosC2);
			$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		}
		else
		{
			$partidos = $this->partidoRepo->getByCampeonatoByFase($campeonato->id, 2);
			$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		}
		$posicionesDB = $this->posicionesRepo->getTabla($campeonato->id, 0, $partidos, $equipos);

		$posiciones = [];
		foreach($posicionesDB as $pos)
		{
			$posicion['id'] = $pos->equipo->id;
			$posicion['POS'] = $pos->POS;
			$posicion['nombre'] = $pos->equipo->nombre;
			$posicion['ruta'] = 'imagenes/equipos/'.$pos->equipo->imagen;
			$posicion['PTS'] = $pos->PTS;
			$posicion['JJ'] = $pos->JJ;
			$posicion['JG'] = $pos->JG;
			$posicion['JE'] = $pos->JE;
			$posicion['JP'] = $pos->JP;			
			$posicion['DIF'] = $pos->DIF;
			$posicion['GF'] = $pos->GF;
			$posicion['GV'] = $pos->GC;

			$posiciones[] = $posicion;

		}


		return json_encode($posiciones);
	}

	public function estadisticas($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$incidencias = $this->eventoPartidoRepo->getByPartido($partidoId);
		$eventosTemp = $this->eventoPartidoRepo->getByEventos($partidoId, [6,7,8,10,11]);
		$eventos = array();
		$golesLocal = 0;
		$golesVisita = 0;
		foreach($eventosTemp as $evento)
		{
			$personaLocal = "";       $personaVisita = "";
            $minLocal = "";           $minVisita = "";
            $urlImagenLocal = "";     $urlImagenVisita = "";
            $resultadoParcial = "";
			if($evento->equipo_id == $partido->equipo_local_id)
			{
				mb_internal_encoding("UTF-8");
				$string = $evento->jugador1->primer_nombre;
				$evento->jugador1->primer_nombre = mb_substr($string,0,1) . '. ';

				$personaLocal = $evento->jugador1->primer_nombre . $evento->jugador1->primer_apellido;
				$minLocal = $evento->minuto . '\'';
				$urlImagenLocal = 'imagenes/eventos/' . $evento->imagen->ruta;

				if($evento->evento_id == 6 || $evento->evento_id == 7 || $evento->evento_id == 8)
				{
					$golesLocal++;
					$resultadoParcial = $golesLocal . ' - ' . $golesVisita;
				}
			}
			else
			{
				mb_internal_encoding("UTF-8");
				$string = $evento->jugador1->primer_nombre;
				$evento->jugador1->primer_nombre = mb_substr($string,0,1) . '. ';
				$personaVisita = $evento->jugador1->primer_nombre . $evento->jugador1->primer_apellido;

				$minVisita = $evento->minuto . '\'';
				$urlImagenVisita = 'imagenes/eventos/' . $evento->imagen->ruta;
				if($evento->evento_id == 6 || $evento->evento_id == 7 || $evento->evento_id == 8)
				{
					$golesVisita++;
					$resultadoParcial = $golesLocal . ' - ' . $golesVisita;
				}
			}

			$e['personaLocal'] = $personaLocal;
			$e['personaVisita'] = $personaVisita;
			$e['golesLocal'] = $golesLocal;
			$e['golesVisita'] = $golesVisita;
			$e['urlImagenLocal'] = $urlImagenLocal;
			$e['urlImagenVisita'] = $urlImagenVisita;
			$e['minLocal'] = $minLocal;
			$e['minVisita'] = $minVisita;
			$e['resultadoParcial'] = $resultadoParcial;
			$eventos[] = $e;
		}

		$alineaciones = array();

		/*ARMADO ANTERIOR*/
		$partidoAnterior['equipoLocal'] = $partido->equipoLocal->nombre;
		$partidoAnterior['equipoVisita'] = $partido->equipoVisita->nombre;
		$partidoAnterior['golesLocal'] = $partido->goles_local;
		$partidoAnterior['golesVisita'] = $partido->goles_visita;
		$partidoAnterior['rutaLocal'] = 'imagenes/equipos/'.$partido->equipoLocal->imagen;
		$partidoAnterior['rutaVisita'] = 'imagenes/equipos/'.$partido->equipoVisita->imagen;
		$partidoAnterior['idL'] = $partido->equipo_local_id;
		$partidoAnterior['idV'] = $partido->equipo_visita_id;
		$partidoAnterior['alineacionlocal'] = 4624;
		$partidoAnterior['alineacionvisita'] = 4626;

		$incidenciasAnterior = [];
		foreach($incidencias as $inc)
		{
			if($inc->evento_id != 20){
				$i['comentario'] = $inc->comentario;
				$i['tiempo'] = $inc->minuto;
				$i['ruta'] = 'imagenes/eventos/'.$inc->imagen->ruta;
				$incidenciasAnterior[] = $i;
			}
		}


		$alineaciones = $this->getAlineaciones($partido->id);

		
		
		$estadisticas['partido'] = $partidoAnterior;
		$estadisticas['incidencias'] = $incidenciasAnterior;
		$estadisticas['eventos'] = $eventos;
		$estadisticas['alineacionLocal'] = $alineaciones['alineacionLocal'];
		$estadisticas['alineacionVisita'] = $alineaciones['alineacionVisita'];
		$estadisticas['dtLocal'] = $alineaciones['dtLocal'];
		$estadisticas['dtVisita'] = $alineaciones['dtVisita'];
		$estadisticas['sustitucionesLocal'] = $alineaciones['sustitucionesLocal'];
		$estadisticas['sustitucionesVisita'] = $alineaciones['sustitucionesVisita'];
		return json_encode($estadisticas);
	}

	function getFecha($extraDays){
		$fecha = date('Y-m-d');
		$nuevafecha = strtotime ( $extraDays , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		return $nuevafecha;
	}



	/** CLANEDARIO **/
	public function getCalendario($campeonatoId, $completo)
	{
		$partidos = array();
		if($completo == 1)
		{
			$sql = "
				SELECT partido.id, equipoLocal.nombre equipoLocal, equipoVisita.nombre equipoVisita, goles_local golesLocal, goles_visita golesVisita, 
					CONCAT('imagenes/equipos/',equipoLocal.imagen) rutaLocal, CONCAT('imagenes/equipos/',equipoVisita.imagen) rutaVisita, fecha, tp.nombre jornada, estadio.nombre estadio,
					ep.nombre estado
				FROM partido, jornada tp, equipo equipoLocal, equipo equipoVisita, estadio, estado_partido ep
				WHERE campeonato_id = " . $campeonatoId . "
					AND jornada_id = tp.id
					AND equipoLocal.id = partido.equipo_local_id
					AND equipoVisita.id = partido.equipo_visita_id
					AND partido.estadio_id = estadio.id
					AND partido.estado_id = ep.id
				ORDER BY fecha ASC, id
			";
			$partidos = \DB::select(\DB::raw($sql));
		}
		else
		{
			$configuracion = $this->configuracionRepo->find(1);
			$diasInicio = $configuracion->parametro1;
			$diasFin = $configuracion->parametro2;

			$fechaInicio = $this->getFecha($diasInicio . ' day');
			$fechaFin = $this->getFecha($diasFin . ' day') . ' 23:59:59';
			/*$fechaInicio = '2015-08-01';
			$fechaFin = '2015-08-02';*/
			$sql = "
				SELECT partido.id, equipoLocal.nombre equipoLocal, equipoVisita.nombre equipoVisita, goles_local golesLocal, goles_visita golesVisita, 
					CONCAT('imagenes/equipos/',equipoLocal.imagen) rutaLocal, CONCAT('imagenes/equipos/',equipoVisita.imagen) rutaVisita, fecha, tp.nombre jornada, estadio.nombre estadio,
					ep.nombre estado
				FROM partido, jornada tp, equipo equipoLocal, equipo equipoVisita, estadio, estado_partido ep
				WHERE campeonato_id = " . $campeonatoId . "
					AND fecha BETWEEN '" . $fechaInicio . " 00:00:00' AND '"  . $fechaFin . " 23:59:59'
					AND jornada_id = tp.id 
					AND equipoLocal.id = partido.equipo_local_id
					AND equipoVisita.id = partido.equipo_visita_id
					AND partido.estadio_id = estadio.id
					AND partido.estado_id = ep.id
				ORDER BY fecha ASC, id
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

	public function getSustituciones($partidoId, $equipoId)
	{
		$sql = '
			SELECT exp.minuto, persona1.primer_nombre n1, persona1.primer_apellido a1, persona2.primer_nombre n2, persona2.primer_apellido a2
			FROM evento_partido exp, persona persona1, persona persona2
			WHERE exp.partido_id = '. $partidoId . '
				AND exp.equipo_id = '. $equipoId . '
				AND exp.jugador1_id = persona1.id
				AND exp.jugador2_id = persona2.id
			ORDER BY exp.minuto, exp.id
		';
		$sustituciones = \DB::select(\DB::raw($sql));
		return $sustituciones;
	}

	public function getAlineaciones($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$alineacionLocal = $this->alineacionRepo->getAlineacionByEstado($partidoId, $partido->equipo_local_id, true);
		$alineacionVisita = $this->alineacionRepo->getAlineacionByEstado($partidoId, $partido->equipo_visita_id, true);
		$dtLocal = $this->alineacionRepo->getTecnico($partidoId, $partido->equipo_local_id);
		$dtVisita = $this->alineacionRepo->getTecnico($partidoId, $partido->equipo_visita_id);
		$alLocal = [];
		$alVisita = [];
		foreach($alineacionLocal as $al)
		{
			$jugador['estitular'] = $al->es_titular;
			$jugador['primerapellido'] = $al->persona->primer_apellido;
			$jugador['primernombre'] = $al->persona->primer_nombre;
			$alLocal[] = $jugador;
		}
		foreach($alineacionVisita as $av)
		{
			$jugador['estitular'] = $av->es_titular;
			$jugador['primerapellido'] = $av->persona->primer_apellido;
			$jugador['primernombre'] = $av->persona->primer_nombre;

			$alVisita[] = $jugador;
		}
		$data['alineacionVisita'] = $alVisita;
		$data['alineacionLocal'] = $alLocal;

		$data['dtLocal'] = [];
		$data['dtVisita'] = [];
		if(!is_null($dtLocal))
		{
			$data['dtLocal']['primerapellido'] = $dtLocal->primer_apellido;
			$data['dtLocal']['primernombre'] = $dtLocal->primer_nombre;
		}  
		if(!is_null($dtVisita))
		{
		  	$data['dtVisita']['primerapellido'] = $dtVisita->primer_apellido;
		  	$data['dtVisita']['primernombre'] = $dtVisita->primer_nombre;
		}

		//* SUSTITUCIONES *///
		$sustitucionesLocal = [];
		$sustitucionesVisita = [];
		$eventosLocal = $this->eventoPartidoRepo->getByEventosByEquipo($partidoId, array(9), $partido->equipo_local_id);
		$eventosVisita = $this->eventoPartidoRepo->getByEventosByEquipo($partidoId, array(9), $partido->equipo_visita_id);
		foreach($eventosLocal as $el)
		{
			$s['tiempo'] = $el->minuto;
			$s['n1'] = $el->jugador1->primer_nombre;
			$s['a1'] = $el->jugador1->primer_apellido;
			$s['n2'] = $el->jugador2->primer_nombre;
			$s['a2'] = $el->jugador2->primer_apellido;
			
			$sustitucionesLocal[] = $s;
		}

		foreach($eventosVisita as $ev)
		{
			$s['tiempo'] = $ev->minuto;
			$s['n1'] = $ev->jugador1->primer_nombre;
			$s['a1'] = $ev->jugador1->primer_apellido;
			$s['n2'] = $ev->jugador2->primer_nombre;
			$s['a2'] = $ev->jugador2->primer_apellido;
			$sustitucionesVisita[] = $s;
		}

		$data['sustitucionesLocal'] = $sustitucionesLocal;
		$data['sustitucionesVisita'] = $sustitucionesVisita;

		$p = new \App\App\Entities\Partido;
		$p->id = $partido->id;
		$p->equipoLocal = $partido->equipoLocal->nombre;
		$p->equipoVisita = $partido->equipoVisita->nombre;
		$p->imagenLocal = $partido->equipoLocal->imagen;
		$p->imagenVisita = $partido->equipoVisita->imagen;
		$p->golesLocal = $partido->goles_local;
		$p->golesVisita = $partido->goles_visita;
		$partido->fecha = strtotime($partido->fecha);
		$p->fecha = date('d/m',$partido->fecha);
		$p->hora = date('H:ia',$partido->fecha);
		$p->estadio = $partido->estadio->nombre;
		$p->estado = $partido->estado->nombre;

		$data['partido'] = $p;
		
		return $data;
	}


}