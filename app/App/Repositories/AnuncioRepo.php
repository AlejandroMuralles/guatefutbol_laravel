<?php

namespace App\App\Repositories;

use App\App\Entities\Anuncio;

class AnuncioRepo extends BaseRepo{

	public function getModel()
	{
		return new Anuncio;
	}

    public function getByPantallaAppByEstado($pantalla,$estados)
    {
        return Anuncio::where('pantalla_app',$pantalla)->whereIn('estado',$estados)->get();
    }

    public function getAnuncioForPantallaApp($pantalla)
    {
        $anuncios = $this->getByPantallaAppByEstado($pantalla,['A']);
        $data = [];
        if(count($anuncios) > 0){
            $data['mostrar_anuncio'] = true;
            $data['anuncio'] = $anuncios[0];
        }else{
            $data['mostrar_anuncio'] = false;
            $data['anuncio'] = null;
        }
        return $data;        
    }

}