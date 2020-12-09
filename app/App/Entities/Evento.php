<?php

namespace App\App\Entities;

class Evento extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','imagen','ruta_agregar', 'ruta_editar','mostrar_en_vivo','estado'];

	protected $table = 'evento';

	public function getImagenAttribute($imagen)
    {
    	if(!is_null($imagen))
    		return \Storage::disk(env('DISK'))->url($imagen);
    	return null;
    }

}