<?php

namespace App\App\Entities;

use Variable;


class Anuncio extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['anunciante','pantalla_app','segundos_mostrandose','minutos_espera','imagen','estado'];

	protected $table = 'anuncio';

    use UserStamps;
    
    public function getDescripcionEstadoAttribute()
    {
        return Variable::getEstadoGeneral($this->estado);
    }

    public function getDescripcionPantallaAppAttribute()
    {
        return Variable::getPantallaApp($this->pantalla_app);
    }

    public function getImagenAttribute($imagen)
    {
    	if(!is_null($imagen))
    		return \Storage::disk('public')->url($imagen);
    	return null;
    }

}