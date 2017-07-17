<?php

namespace App\App\Repositories;

use App\App\Entities\Departamento;

class DepartamentoRepo extends BaseRepo{

	public function getModel()
	{
		return new Departamento;
	}

	public function all($orderBy)
	{
		return Departamento::with('pais')->orderBy($orderBy)->get();
	}

}