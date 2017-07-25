<?php

namespace App\App\Entities;
use Variable;

class Partido extends \Eloquent {

	use UserStamps;

	protected $fillable = ['campeonato_id','fecha','equipo_local_id','equipo_visita_id','goles_local','goles_visita',
							'jornada_id','arbitro_central_id','estadio_id','descripcion_penales','estado','estado_tiempo','fecha_tiempo'];

	protected $table = 'partido';

	public function equipo_local()
	{
		return $this->belongsTo(Equipo::class,'equipo_local_id');
	}

	public function equipo_visita()
	{
		return $this->belongsTo(Equipo::class,'equipo_visita_id');
	}

	public function estadio()
	{
		return $this->belongsTo(Estadio::class);
	}

	public function jornada()
	{
		return $this->belongsTo(Jornada::class);
	}

	public function campeonato()
	{
		return $this->belongsTo(Campeonato::class);
	}

	public function arbitro_central()
	{
		return $this->belongsTo(Persona::class,'arbitro_central_id');
	}

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoPartido($this->estado);
	}

	public function getTiempoAttribute()
	{
		if(is_null($this->fecha_tiempo))
			return $this->estado_tiempo;

		$tiempo = Variable::getHorasMinutosSegundosBetweenFechas(date('Y-m-d H:i:s'), $this->fecha_tiempo);
		$tiempo = explode(':', $tiempo);
		$horas = intval($tiempo[0]);
		$minutos = intval($tiempo[1]);
		$segundos = intval($tiempo[2]);
		if($this->estado_tiempo == 'P')
		{
			$minutos = 0;
		}
		elseif($this->estado_tiempo == 'FPT')
		{
			return $this->estado_tiempo;
			//$minutos = 45; $segundos = 0;
		}
		elseif($this->estado_tiempo == 'ST')
		{
			$minutos += 45;
		}
		elseif($this->estado_tiempo == 'PTE')
		{
			$minutos += 90;
		}
		elseif($this->estado_tiempo == 'FPTE')
		{
			return $this->estado_tiempo;
			//$minutos = 105; $segundos = 0;
		}
		elseif($this->estado_tiempo == 'STE')
		{
			$minutos += 105;
		}
		elseif($this->estado_tiempo == 'FT'){
			return $this->estado_tiempo;
		}
		$segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);
		return $minutos . ':' . $segundos;
	}

}