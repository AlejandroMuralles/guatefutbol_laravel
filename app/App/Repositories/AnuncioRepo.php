<?php

namespace App\App\Repositories;

use App\App\Entities\Anuncio;

class AnuncioRepo extends BaseRepo{

	public function getModel()
	{
		return new Anuncio;
	}

	public function getSiguiente($anuncioId, $tipo, $estado)
	{
		$index = 0;
		$anuncios = Anuncio::where('tipo',$tipo)->get();
		foreach($anuncios as $anuncio)
		{
			if($anuncio->id == $anuncioId)
			{
				break;
			}
			$index++;
		}
		$nextIndex = $index + 1;
		if(isset($anuncios[$nextIndex]) && $anuncios[$nextIndex]->estado == 'A'){
			return $anuncios[$nextIndex];
		}
		else
		{
			$anuncios = Anuncio::where('tipo',$tipo)->whereIn('estado',$estado)->get();
			foreach($anuncios as $anuncio)
			{
				if(count($anuncios) > 0){
					return $anuncios[0];
				}
				else{
					return null;
				}
			}
		}
		return null;
	}

}