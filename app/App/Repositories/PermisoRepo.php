<?php

namespace App\App\Repositories;

use App\App\Entities\Permiso;
use App\App\ExtraEntities\Menu;

class PermisoRepo extends BaseRepo {

	public function getModel()
	{
		return new Permiso;
	}

	public function tienePermiso($perfilId, $ruta)
	{
		$sql = '
			SELECT *
			FROM permiso p, vista v 
			WHERE p.vista_id = v.id
				AND p.perfil_id = '. $perfilId .'
				AND v.ruta = \''. $ruta .'\'
		';
		$result = \DB::select(\DB::raw($sql));
		return count($result)  != 0 ? true : false ;
	}

	public function getMenu($perfilId, $isAdmin)
	{
		$sql = '
			SELECT *
			FROM permiso p, vista v, modulo m
			WHERE p.perfil_id = ' .$perfilId . '
				AND p.vista_id = v.id 
				AND v.modulo_id = m.id 
				AND m.is_admin = '.$isAdmin.'
				AND v.menu != 0
			GROUP BY m.id
		';
		$menuPublico = array();
		$modulos = \DB::select(\DB::raw($sql));
		//dd($sql);
		foreach($modulos as $modulo)
		{
			$menuItem = new Menu($modulo);
			$sql = '
				SELECT v.ruta, v.nombre, v.icono
				FROM permiso p, vista v 
				WHERE p.perfil_id = '.$perfilId.'
					AND v.modulo_id = '.$modulo->id.'
					AND v.menu = 1
					AND p.vista_id = v.id
				ORDER BY v.nombre
			';
			$menuItem->vistas = \DB::select(\DB::raw($sql));
			$menuPublico[] = $menuItem;
		}
		return $menuPublico;
	}

	public function getPermisos($perfilId, $tipoModulo)
	{
		$sql = '
			SELECT *
			FROM vista v, modulo m
			WHERE v.modulo_id = m.id 
				AND m.is_admin = '.$tipoModulo.'
			GROUP BY m.id
		';
		$modulosVistas = array();
		$modulos = \DB::select(\DB::raw($sql));

		foreach($modulos as $modulo)
		{
			$moduloVista = new Menu($modulo);
			$sql = '
				SELECT v.nombre, v.id, \'checked\' as checked
				FROM vista v 
				WHERE v.modulo_id = '.$modulo->id.'
					AND v.id IN ( 
						SELECT vista_id FROM permiso WHERE perfil_id = '.$perfilId.' 
					)
				UNION
				SELECT v.nombre, v.id, \'\' as checked
				FROM vista v 
				WHERE v.modulo_id = '.$modulo->id.'
					AND v.id NOT IN ( 
						SELECT vista_id FROM permiso WHERE perfil_id = '.$perfilId.' 
					)
				ORDER BY nombre
			';
			$moduloVista->vistas = \DB::select(\DB::raw($sql));
			$modulosVistas[] = $moduloVista;
		}
		
		return $modulosVistas;
	}

}