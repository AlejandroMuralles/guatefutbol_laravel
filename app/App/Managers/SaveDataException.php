<?php

namespace App\App\Managers;

class SaveDataException extends \Exception {

	protected $error;
	protected $exception;

	public function __construct($error, $exception)
	{
		$this->error = $error;
		$this->exception = $exception;
	}

	public function getError()
	{
		return $this->error;
	}

	public function getException()
	{
		return $this->exception;
	}

}