<?php

namespace App\App\Managers;

use App\App\Repositories\PersonaRepo;
use App\App\Repositories\AlineacionRepo;
use App\App\Repositories\EventoPartidoRepo;

use App\App\Entities\EventoPartido;
use Redirect, Session, Twitter;
use Facebook\Facebook as Facebook;

class EventoPartidoManager extends BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;

	}

	function getRules()
	{

		$rules = [
			'partido_id'  => 'required',
			'evento_id'  => 'required',
			'minuto'  => 'required|integer',
		];

		return $rules;
	}

	function getRulesPersona()
	{
		$rules = [
			'partido_id'  => 'required',
			'equipo_id'  => 'required',
			'jugador1_id'  => 'required',
			'evento_id'  => 'required',
			'minuto'  => 'required|integer',
		];
		return $rules;
	}

	/*Cambios*/
	function getRulesPersonas()
	{
		$rules = [
			'partido_id'  => 'required',
			'equipo_id'  => 'required',
			'jugador1_id'  => 'required',
			'jugador2_id'  => 'required',
			'evento_id'  => 'required',
			'minuto'  => 'required|integer',
		];
		return $rules;
	}

	function prepareData($data)
	{
		if($data['evento_id'] == 11)
			$data['doble_amarilla'] = isset($data['doble_amarilla']) ? 1 : 0;
		return $data;
	}

	function agregar($partido)
	{

		$rules = $this->getRules();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
        try{
        	\DB::beginTransaction();
				$this->entity->fill($this->prepareData($this->data));
				if($this->entity->evento_id == 2){
					$partido->goles_local = 0;
					$partido->goles_visita = 0;
					$partido->estado = 2;
					$partido->estado_tiempo = 'PT';
					$partido->fecha_tiempo = $this->data['fecha_tiempo'];
				}
				if($this->entity->evento_id == 3){
					$partido->estado_tiempo = 'FPT';
					$partido->fecha_tiempo = null;
				}
				if($this->entity->evento_id == 4){
					$partido->estado_tiempo = 'ST';
					$partido->fecha_tiempo = $this->data['fecha_tiempo'];
				}
				$partido->save();

				$this->entity->comentario = $this->getComentario($partido, $this->entity->evento_id,null, null);
				$this->entity->save();
			\DB::commit();

			if(isset($this->data['facebook'])){
				if($this->entity->evento_id == 12)
					$this->postFacebook($this->entity->comentario . ' Minuto ' . $this->entity->minuto. ' ' . $partido->campeonato->hashtag);
				else
					$this->postFacebook($this->entity->comentario. ' ' . $partido->campeonato->hashtag);
			}
			if(isset($this->data['twitter'])){
				if($this->entity->evento_id == 12)
					$this->postTwitter($this->entity->comentario . ' Minuto ' . $this->entity->minuto. ' ' . $partido->campeonato->hashtag);
				else
					$this->postTwitter($this->entity->comentario. ' ' . $partido->campeonato->hashtag);
			}
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}


	}

	function finalizarPartido($partido)
	{
		$rules = $this->getRules();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
        try{

        	$eventoPartidoRepo = new EventoPartidoRepo();
        	$alineacionRepo = new AlineacionRepo();

        	\DB::beginTransaction();
        		$this->entity->fill($this->prepareData($this->data));

        		$partido->estado = 3;
        		if($this->entity->evento_id == 5 || $this->entity->evento_id == 16){
					$partido->estado_tiempo = 'FT';
					$partido->fecha_tiempo = null;
				}
        		$partido->save();



				/* Componer minutos jugados */
				$minutoFinPartido = $this->data['minuto'];

				$personasConEventos = $eventoPartidoRepo->getPersonasWithEventoByPartido(array(9,11),$partido->id);

				$personaId = 0;
				foreach($personasConEventos as $persona)
				{
					$personaId = $persona->id;

					$eventosDeJugador = $eventoPartidoRepo->getAllByEventoByPartidoByPersona(array(9,11), $partido->id, $persona->id);
					$cantidadEventos = count($eventosDeJugador);
					$alineacion = null;

					if($cantidadEventos == 1)
					{
						$exp = $eventosDeJugador[0];
						$minutoEvento = $exp->minuto;

						/*SI EL EVENTO ES ROJA*/
						if($exp->evento_id == 11){
							/* SI EL EVENTO ES ROJA */
							$alineacion = $alineacionRepo->getJugadorByPartido($partido->id, $persona->id);
							if($alineacion->es_titular)
							{
								if($exp->minuto > 90)
									$alineacion->minutos_jugados = 90;
								else
									$alineacion->minutos_jugados = $minutoEvento;
							}
							/*SI EL EVENTO ES ROJA PERO ESTABA EN LA BANCA*/
	                        // no se ponen minutos jugados
						}
						/*SI EL EVENTO ES CAMBIO*/
						else if($exp->evento_id == 9){
							/*Si es jugador que sale*/
							$jugadorSaleId = $exp->jugador2_id;
							if($jugadorSaleId == $persona->id)
							{
								$alineacion = $alineacionRepo->getJugadorByPartido($partido->id, $jugadorSaleId);

								if($minutoEvento > 90)
									$alineacion->minutos_jugados = 90;
								else
									$alineacion->minutos_jugados = $minutoEvento;
							}
							/*si es jugador que entra*/
							else{
								$jugadorEntraId = $exp->jugador1_id;
								$alineacion = $alineacionRepo->getJugadorByPartido($partido->id, $jugadorEntraId);

								if($minutoEvento == $minutoFinPartido)
									$alineacion->minutos_jugados = 1;
								else if($minutoEvento >= 90)
									$alineacion->minutos_jugados = $minutoEvento - 90;
								else
									$alineacion->minutos_jugados = 90 - $minutoEvento;
							}
						}
					}
					else if($cantidadEventos == 2)
					{
						$exp1 = $eventosDeJugador[0];
						$minutoEvento1 = $exp1->minuto;
						$exp2 = $eventosDeJugador[1];
						$minutoEvento2 = $exp2->minuto;

						/* CAMBIO Y ROJA */
						if($exp1->evento_id == 9 && $exp2->evento_id == 11)
						{
							/* SI EL JUGADOR SALE Y LUEGO ROJA */
							$jugadorSaleId = $exp1->jugador2_id;
							if($jugadorSaleId == $persona->id)
							{
								$alineacion = $alineacionRepo->getJugadorByPartido($partido->id, $exp1->jugador2_id);
								$alineacion->minutos_jugados = $minutoEvento1;
							}
							/* SI EL JUGADOR ENTRA Y LUEGO ROJA */
							else{
								$alineacion = $alineacionRepo->getJugadorByPartido($partido->id, $exp1->jugador1_id);
								if($minutoEvento2 > 90)
									$alineacion->minutos_jugados = 90 - $minutoEvento1;
								else
									$alineacion->minutos_jugados = $minutoEvento2 - $minutoEvento1;
							}
						}
						/* CAMBIO Y CAMBIO */
                        /* JUGADOR ENTRO Y LUEGO SALIO */
						else if($exp1->evento_id == 9 && $exp2->evento_id == 9){
							$alineacion = $alineacionRepo->getJugadorByPartido($partido->id, $exp1->jugador1_id);
							if($minutoEvento2 > 90)
								$alineacion->minutos_jugados = 90 - $minutoEvento1;
							else
								$alineacion->minutos_jugados = $minutoEvento2 - $minutoEvento1;
						}
					}
					else if($cantidadEventos == 3)
					{
						$exp1 = $eventosDeJugador[0];
						$minutoEvento1 = $exp1->minuto;
						$exp2 = $eventosDeJugador[1];
						$minutoEvento2 = $exp2->minuto;
						$exp3 = $eventosDeJugador[2];
						$minutoEvento3 = $exp3->minuto;
						/* JUGADOR ENTRO, LUEGO SALIO Y LUEGO LE SACARON ROJA YA EN LA BANCA */
						if($exp1->evento_id == 9 && $exp2->evento_id == 9 && $exp3->evento_id == 11)
						{
							$alineacion = $alineacionRepo->getJugadorByPartido($partido->id, $exp1->jugador1_id);
							if($minutoEvento2 > 90)
								$alineacion->minutos_jugados = 90 - $minutoEvento1;
							else
								$alineacion->minutos_jugados = $minutoEvento2 - $minutoEvento1;
						}
					}

					if(!is_null($alineacion))
					{
						$alineacion->save();
					}

				}


				$this->entity->comentario = $this->getComentario($partido, $this->entity->evento_id,null, null);
				$this->entity->save();
			\DB::commit();

			if(isset($this->data['facebook'])){
				$this->postFacebook($this->entity->comentario. ' ' . $partido->campeonato->hashtag);
			}
			if(isset($this->data['twitter'])){
				$this->postTwitter($this->entity->comentario. ' ' . $partido->campeonato->hashtag);
			}
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}

	}

	function agregarPersona($partido,$equipoId)
	{
		if($this->data['evento_id'] == 6 || $this->data['evento_id'] == 7 || $this->data['evento_id'] == 8)
			$rules = $this->getRules();
		else
			$rules = $this->getRulesPersona();

		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
        try{
        	$eventoPartidoRepo = new EventoPartidoRepo();
        	$alineacionRepo = new AlineacionRepo();
        	$personaRepo = new PersonaRepo();
        	\DB::beginTransaction();

        		/*Se llenan los datos que vienen*/
				$this->entity->fill($this->prepareData($this->data));
				if(isset($this->data['doble_amarilla']))
				{
					$this->entity->doble_amarilla = 1;
				}
				/*Se actualiza el partido --> Goles */
				if($this->entity->evento_id == 6 || $this->entity->evento_id == 7 || $this->entity->evento_id == 8){

					/** ENCAJAR GOL **/
					$eventoEncajaGol = new EventoPartido();
					$eventoEncajaGol->fill($this->prepareData($this->data));
					$eventoEncajaGol->jugador1_id = $this->data['portero_encaja_gol'];
					$eventoEncajaGol->evento_id = 20;
					$equipoContrarioId = 0;
					//cambio el 10 de abril de 2017, estaban al reves por si se requiere estadistica.
					if($partido->equipo_local_id == $equipoId) $equipoContrarioId = $partido->equipo_visita_id;
					else $equipoContrarioId = $partido->equipo_local_id;

					$eventoEncajaGol->equipo_id = $equipoContrarioId;

					$eventoEncajaGol->comentario = $this->getComentario($partido, $eventoEncajaGol->evento_id,
														$equipoContrarioId, $personaRepo->find($eventoEncajaGol->jugador1_id));
					$eventoEncajaGol->save();


					/** FIN ENCAJAR GOL **/

					if($equipoId == $partido->equipo_local_id)
					{
						$partido->goles_local = $partido->goles_local + 1;
					}
					else
					{
						$partido->goles_visita = $partido->goles_visita + 1;
					}
					$partido->save();
				}
				/*Si es roja se actualizan los minutos jugados*/
				if($this->entity->evento_id == 11)
				{
					$alineacion = $alineacionRepo->getJugadorByPartido($partido->id, $this->entity->jugador1_id);
					$alineacion->minutos_jugados = $this->entity->minuto;
					$alineacion->save();
				}
				/*Si es cambio se actualizan los minutos jugados*/
				if($this->entity->evento_id == 9)
				{
					$alineacion = $alineacionRepo->getJugadorByPartido($partido->id, $this->entity->jugador1_id);
					$alineacion->minutos_jugados = $this->entity->minuto;
					$alineacion->save();

					$alineacion2 = $alineacionRepo->getJugadorByPartido($partido->id, $this->entity->jugador2_id);
					$alineacion2->minutos_jugados = 1;
					$alineacion2->save();
				}

				/*Se obtiene el comentario*/
				if($this->entity->evento_id != 12)
				{
					//* si es cambio  *//
					if($this->entity->evento_id == 9)
					{
						$this->entity->comentario = $this->getComentario($partido, $this->entity->evento_id,
														$this->entity->equipo_id, $personaRepo->find($this->entity->jugador1_id),
														$personaRepo->find($this->entity->jugador2_id));
					}
					else{
						$this->entity->comentario = $this->getComentario($partido, $this->entity->evento_id,
														$this->entity->equipo_id, $personaRepo->find($this->entity->jugador1_id));
					}
				}


				$this->entity->save();


			\DB::commit();

			if(isset($this->data['facebook'])){
				//Si es gol o autogol, es necesario publicar imagen.
				if($this->entity->evento_id == 6 || $this->entity->evento_id == 7){
					$equipoGol = $this->getEquipo($partido, $equipoId);
					$imagen ='assets/imagenes/goles_equipos/' . $equipoGol->id . '.png';
					if(file_exists($imagen))
					{
						$imagen = \URL::asset('assets/imagenes/goles_equipos/') . '/' . $equipoGol->id . '.png';
						$this->postImageFacebook($imagen, $this->entity->comentario . '. Minuto ' . $this->entity->minuto . ' ' . $partido->campeonato->hashtag);
					}
					else
						$this->postFacebook($this->entity->comentario . '. Minuto ' . $this->entity->minuto . ' ' . $partido->campeonato->hashtag);
				}
				else
					$this->postFacebook($this->entity->comentario . '. Minuto ' . $this->entity->minuto . ' ' . $partido->campeonato->hashtag);

			}
			//dd($this->data['twitter']);
			if(isset($this->data['twitter'])){
				//dd("check tw");
				if($this->entity->evento_id == 6 || $this->entity->evento_id == 7){
					$equipoGol = $this->getEquipo($partido, $equipoId);
					$imagen ='assets/imagenes/goles_equipos/' . $equipoGol->id . '.png';
					if(file_exists($imagen)){
						$imagen = \URL::asset('assets/imagenes/goles_equipos/') . '/' . $equipoGol->id . '.png';
						$this->postImageTwitter($imagen, $this->entity->comentario . '. Minuto ' . $this->entity->minuto . ' ' . $partido->campeonato->hashtag);
					}
					else{
						$this->postTwitter($this->entity->comentario . '. Minuto ' . $this->entity->minuto . ' ' . $partido->campeonato->hashtag);
					}

				}
				else
				{
					$this->postTwitter($this->entity->comentario . '. Minuto ' . $this->entity->minuto . ' ' . $partido->campeonato->hashtag);
				}
			}
		}
		catch(\Exception $ex)
		{
			//dd($ex);
			throw new SaveDataException('¡Error!', $ex);
		}


	}

	public function eliminarEvento($partido)
	{
		try{

        	\DB::beginTransaction();
				if($this->entity->evento_id == 6 || $this->entity->evento_id == 7 || $this->entity->evento_id == 8)
				{
					if($partido->equipo_local_id == $this->entity->equipo_id)
					{
						$partido->goles_local = $partido->goles_local - 1;
					}
					else{
						$partido->goles_visita = $partido->goles_visita - 1;
					}
					$partido->save();
				}
				$this->entity->delete();
			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}
	}


	private function getComentario($partido, $eventoId, $equipoId = null, $jugador = null, $jugador2 = null)
	{

		if($eventoId == 2)
		{
			return 'Inicia el partido. ' . $this->getResultado($partido);
		}
		if($eventoId == 3)
		{
			return 'Fin del primer tiempo. ' . $this->getResultado($partido);
		}
		if($eventoId == 4)
		{
			return 'Inicia el segundo tiempo. ' . $this->getResultado($partido);
		}
		if($eventoId == 5)
		{
			return 'Finaliza el partido. ' . $this->getResultado($partido);
		}
		if($eventoId == 13)
		{
			return 'Inicia el primer tiempo extra. ' . $this->getResultado($partido);
		}
		if($eventoId == 14)
		{
			return 'Fin del primer tiempo extra. ' . $this->getResultado($partido);
		}
		if($eventoId == 15)
		{
			return 'Inicia el segundo tiempo extra. ' . $this->getResultado($partido);
		}
		if($eventoId == 16)
		{
			return 'Finaliza el segundo tiempo extra. ' . $this->getResultado($partido);
		}
		if($eventoId == 17)
		{
			return 'Inicia el lanzamiento de penales. ' . $this->getResultado($partido);
		}
		if($eventoId == 18)
		{
			return 'Finaliza el lanzamiento de penales. ' . $this->getResultado($partido);
		}
		if($eventoId == 6 || $eventoId == 8)
		{
			$equipo = $this->getEquipo($partido, $equipoId);
			if(!is_null($jugador))
				return '¡GOOOL! de ' .$equipo->nombre . '. Anota ' . $jugador->nombre_completo . '. ' . $this->getResultado($partido);

			return '¡GOOOL! de ' .$equipo->nombre . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 7)
		{
			$equipo = $this->getEquipo($partido, $equipoId);
			if(!is_null($jugador))
				return '¡GOOOL! de ' .$equipo->nombre . '. Anota en propia puerta ' . $jugador->nombre_completo . '. ' . $this->getResultado($partido);

			return '¡GOOOL! de ' .$equipo->nombre . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 9)
		{
			$equipo = $this->getEquipo($partido, $equipoId);
			return 'CAMBIO en '.$equipo->nombre. '. Sale ' . $jugador2->nombre_completo . ' y entra ' . $jugador->nombre_completo . '. ';
		}
		if($eventoId == 10)
		{
			$equipo = $this->getEquipo($partido, $equipoId);
			return 'AMARILLA para el jugador de ' . $equipo->nombre . ' ' . $jugador->nombre_completo;
		}
		if($eventoId == 11)
		{
			$equipo = $this->getEquipo($partido, $equipoId);
			if($this->entity->doble_amarilla){
				return 'ROJA por doble amonestación para el jugador de ' . $equipo->nombre . ' ' . $jugador->nombre_completo;
			}
			return 'ROJA para el jugador de ' . $equipo->nombre . ' ' . $jugador->nombre_completo;
		}
		if($eventoId == 12)
		{
			return $this->entity->comentario;
		}
		if($eventoId == 20)
		{
			if($jugador)
				return 'Gol encajado al portero ' . $jugador->nombre_completo;
			return 'Gol encajado';
		}
	}

	private function getResultado($partido)
	{
		return $partido->equipo_local->nombre . ' ' .
					$partido->goles_local . '-' . $partido->goles_visita . ' ' .
				$partido->equipo_visita->nombre;
	}

	private function getEquipo($partido, $equipoId)
	{
		if($equipoId == $partido->equipo_local->id)
		{
			return $partido->equipo_local;
		}
		else
		{
			return $partido->equipo_visita;
		}
	}

	public function postFacebook($mensaje)
	{
		try{
				$config = array(
		 					'app_id' => env('FB_API_KEY'),
		         	'app_secret' => env('FB_API_SECRET'),
		        	'allowSignedRequest' => false
	    	);

	    	$facebook = new Facebook($config);
				$fanPageId = env('FB_FANPAGE_ID');
				$accessToken = \Session::get('access_token');
				$data['message'] = $mensaje;
    		$post_url = '/'.$fanPageId.'/feed';
    		$facebook->post($post_url, $data, $accessToken);
    		\Session::flash('fb-success', 'Se posteó en facebook correctamente.');
		}
		catch(\Exception $ex)
		{
			\Session::flash('fb-error', 'ERROR DE FACEBOOK: ' . $ex->getMessage());
            return Redirect::back();
		}
	}

	public function postImageFacebook($imagen, $mensaje)
	{
		try{
			$config = array(
	 			'app_id' => env('FB_API_KEY'),
	         	'app_secret' => env('FB_API_SECRET'),
	        	'allowSignedRequest' => false
	    	);

	    	$facebook = new Facebook($config);
			$fanPageId = env('FB_FANPAGE_ID');
			$accessToken = \Session::get('access_token');
			$data['caption'] = $mensaje;
			$data['url'] = $imagen;
			//dd($data);
    		$post_url = '/'.$fanPageId.'/photos';
    		$facebook->post($post_url, $data, $accessToken);
    		\Session::flash('fb-success', 'Se posteó en facebook correctamente.');
		}
		catch(\Exception $ex)
		{
			\Session::flash('fb-error', 'ERROR DE FACEBOOK: ' . $ex->getMessage());
            return Redirect::back();
		}
	}

	public function postTwitter($mensaje)
	{
		return Twitter::postTweet(array('status' => $mensaje, 'format' => 'json'));
	}

	public function postImageTwitter($urlImagen, $mensaje)
	{
		$uploaded_media = Twitter::uploadMedia(['media' => file_get_contents($urlImagen)]);
  	return Twitter::postTweet(['status' => $mensaje, 'media_ids' =>  $uploaded_media->media_id_string]);
	}

}
