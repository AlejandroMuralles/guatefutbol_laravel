<?php

namespace App\App\Entities;

use Illuminate\Support\Facades\Storage;
use App\App\Components\Variable;


class Anuncio extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['anunciante','nombre_anunciante','pantalla_app','segundos_mostrandose','minutos_espera','imagen','estado','link','tipo'];

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

    public function getDescripcionAnuncianteAttribute()
    {
        return Variable::getTipoAnunciante($this->anunciante);
    }

    public function getDescripcionTipoAttribute()
    {
        return Variable::getTipoAnuncio($this->tipo);
    }

    public function getImagenAttribute($imagen)
    {
    	if(!is_null($imagen))
    		return Storage::disk(env('DISK'))->url($imagen);
    	return null;
    }

}