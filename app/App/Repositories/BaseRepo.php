<?php

namespace App\App\Repositories;

abstract class BaseRepo {

	protected $model;

	public function __construct()
	{
		$this->model = $this->getModel();
	}

	abstract public function getModel();

	public function all($orderBy)
	{
		return $this->model->orderBy($orderBy)->get();
	}

	public function orderList($orderBy, $value, $key)
	{
		return $this->model->orderBy($orderBy)->pluck($value, $key)->toArray();
	}

	public function find($id)
	{
		return $this->model->find($id);
	}

	public function lists($value, $key)
	{
		return $this->model->pluck($value, $key)->toArray();
	}

}