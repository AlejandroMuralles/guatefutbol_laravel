<?php

namespace App\App\Entities;

class Evento extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','imagen','ruta_agregar', 'ruta_editar','mostrar_en_vivo','estado'];

	protected $table = 'evento';

}