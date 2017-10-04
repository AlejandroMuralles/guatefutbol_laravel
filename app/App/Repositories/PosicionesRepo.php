<?php

namespace App\App\Repositories;

class PosicionesRepo {

	protected $partidoRepo;

	public function __construct(PartidoRepo $partidoRepo)
	{
		$this->partidoRepo = $partidoRepo;
	}

    public function getTabla($campeonatoId, $tipoTabla, $partidos, $equipos, $esAcumulada = 0)
	{
		foreach($partidos as $partido)
		{
            if($partido->estado_id != 1)
            {
                $goles_local = $partido->goles_local != null ? $partido->goles_local : 0;
                $goles_visita = $partido->goles_visita != null ? $partido->goles_visita : 0;

                $equipoLocal = $this->obtenerEquipo($equipos, $partido->equipo_local->id);

                $equipoVisita = $this->obtenerEquipo($equipos, $partido->equipo_visita->id);

                // tipoTabla = 0 -> tabla general ---- tipoTabla = 1 -> tabla local
                $equipoLocal->GV = 0;
                $equipoVisita->GV = 0;
                if($tipoTabla == 0 || $tipoTabla == 1) 
                {
                    $equipoLocal->JJ += 1;

                    if ($goles_local > $goles_visita) {
                        $equipoLocal->JG += 1;
                        $equipoLocal->PTS += 3;
                    }
                    else if ($goles_local < $goles_visita) {
                        $equipoLocal->JP += 1;
                    }
                    else {
                        $equipoLocal->JE += 1;
                        $equipoLocal->PTS += 1;
                    }
                    $equipoLocal->GF += $goles_local;
                    $equipoLocal->GC += $goles_visita;
                    $equipoLocal->DIF += ($goles_local - $goles_visita);
                }
                // tipoTabla = 0 -> tabla general ---- tipoTabla = 2 -> tabla visita
                if($tipoTabla == 0 || $tipoTabla == 2){
                    $equipoVisita->JJ += 1;

                    if ($goles_local > $goles_visita) {
                        $equipoVisita->JP += 1;
                    }
                    else if ($goles_local < $goles_visita) {
                        $equipoVisita->JG += 1;
                        $equipoVisita->PTS += 3;
                    }
                    else {
                        $equipoVisita->JE += 1;
                        $equipoVisita->PTS += 1;
                    }
                    $equipoVisita->GF += $goles_visita;
                    $equipoVisita->GC += $goles_local;
                    $equipoVisita->GV += $goles_visita;
                    $equipoVisita->DIF += ($goles_visita - $goles_local);
                }
            }
		}

        /* Quitar puntos a chiantla */
        if($campeonatoId == 53 && $esAcumulada == 1){
            foreach($equipos as $index => $equipo)
            {
                if($equipo->equipo->id == 82){
                    $equipo->PTS -= 3;
                }
            }
        }

        /* Quitar puntos a chiantla */
        if($campeonatoId == 60 && $esAcumulada == 1){
            foreach($equipos as $index => $equipo)
            {
                if($equipo->equipo->id == 69){
                    $equipo->PTS -= 3;
                }
            }
        }

		usort($equipos, array('App\App\Repositories\PosicionesRepo','cmp'));
		$pos = 0;
		foreach($equipos as $equipo)
		{
			$pos++;
			$equipo->POS = $pos;
		}
		return $equipos;
	}

    public function getTablaByLiga($ligaId, $tipoTabla, $partidos, $equipos, $esAcumulada = 0)
    {
        foreach($partidos as $partido)
        {
            if($partido->estado_id != 1)
            {
                $goles_local = $partido->goles_local != null ? $partido->goles_local : 0;
                $goles_visita = $partido->goles_visita != null ? $partido->goles_visita : 0;

                $equipoLocal = $this->obtenerEquipo($equipos, $partido->equipo_local->id);

                $equipoVisita = $this->obtenerEquipo($equipos, $partido->equipo_visita->id);

                // tipoTabla = 0 -> tabla general ---- tipoTabla = 1 -> tabla local
                $equipoLocal->GV = 0;
                $equipoVisita->GV = 0;
                if($tipoTabla == 0 || $tipoTabla == 1) 
                {
                    $equipoLocal->JJ += 1;

                    if ($goles_local > $goles_visita) {
                        $equipoLocal->JG += 1;
                        $equipoLocal->PTS += 3;
                    }
                    else if ($goles_local < $goles_visita) {
                        $equipoLocal->JP += 1;
                    }
                    else {
                        $equipoLocal->JE += 1;
                        $equipoLocal->PTS += 1;
                    }
                    $equipoLocal->GF += $goles_local;
                    $equipoLocal->GC += $goles_visita;
                    $equipoLocal->DIF += ($goles_local - $goles_visita);
                }
                // tipoTabla = 0 -> tabla general ---- tipoTabla = 2 -> tabla visita
                if($tipoTabla == 0 || $tipoTabla == 2){
                    $equipoVisita->JJ += 1;

                    if ($goles_local > $goles_visita) {
                        $equipoVisita->JP += 1;
                    }
                    else if ($goles_local < $goles_visita) {
                        $equipoVisita->JG += 1;
                        $equipoVisita->PTS += 3;
                    }
                    else {
                        $equipoVisita->JE += 1;
                        $equipoVisita->PTS += 1;
                    }
                    $equipoVisita->GF += $goles_visita;
                    $equipoVisita->GC += $goles_local;
                    $equipoVisita->GV += $goles_visita;
                    $equipoVisita->DIF += ($goles_visita - $goles_local);
                }
            }
        }

        
        if($ligaId == 23){
            foreach($equipos as $index => $equipo)
            {
                /* Quitar puntos a siquinalá del campeoanto 63*/
                if($equipo->equipo->id == 82){
                    $equipo->PTS -= 3;
                }
                /* Quitar puntos a chiantla del campeonato 59*/
                if($equipo->equipo->id == 69){
                    $equipo->PTS -= 3;
                }
            }
        }

        usort($equipos, array('App\App\Repositories\PosicionesRepo','cmp'));
        $pos = 0;
        foreach($equipos as $equipo)
        {
            $pos++;
            $equipo->POS = $pos;
        }
        return $equipos;
    }

	function cmp( $a, $b ) {
        if ($a->PTS == $b->PTS) {
            if ($a->DIF == $b->DIF) {
                if($a->GF == $b->GF){
                    if($a->GC == $b->GC)
                    	return strcmp($a->equipo->nombre, $b->equipo->nombre);
                    else
                        return $a->GC > $b->GC ? -1 : 1;
                }
                else{
                    return $a->GF > $b->GF ? -1 : 1;
                }
            }
            return $a->DIF > $b->DIF ? -1 : 1;
        }
        return $a->PTS > $b->PTS ? -1 : 1;
	}

	public function obtenerEquipo(&$equipos, $equipoId)
	{
		foreach($equipos as $equipo){
			if($equipo->equipo->id == $equipoId)
				return $equipo;
		}
	}

	

}
