<?php

namespace App\App\Entities;
use Variable;

class Persona extends \Eloquent {

	use UserStamps;

	protected $fillable = ['primer_nombre','segundo_nombre','primer_apellido','segundo_apellido','fecha_nacimiento','departamento_id','pais_id','rol','portero','estado'];

	protected $table = 'persona';

	public function getDescripcionRolAttribute()
	{
		return Variable::getRol($this->rol);
	}

	public function pais()
	{
		return $this->belongsTo(Pais::class);
	}

	public function departamento()
	{
		return $this->belongsTo(Departamento::class);
	}

	public function getNombreCompletoAttribute()
	{
		$portero = $this->portero ? ' (P)' : '';
		return $this->primer_nombre . ' ' . $this->segundo_nombre . ' ' . $this->primer_apellido . ' ' . $this->segundo_apellido . $portero;
	}

	public function getNombreCompletoApellidosAttribute()
	{
		$portero = $this->portero ? ' (P)' : '';
		return $this->primer_apellido . ' ' . $this->segundo_apellido . ' ' . $this->primer_nombre . ' ' . $this->segundo_nombre . $portero;
	}

	public function getLugarNacimientoAttribute()
	{
		if(!is_null($this->departamento_id))
		{
			return rtrim($this->departamento->nombre, ",");
		}
		else{
			return $this->pais->nombre;
		}
	}

}