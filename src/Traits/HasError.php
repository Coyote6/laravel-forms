<?php
	
	
namespace Coyote6\LaravelForms\Traits;

use Coyote6\LaravelForms\Components\Error;

trait HasError {
	

	public Error|false $error = false;


	// Set Error
	//
	// @param Error|string $error - The error component or input name to associate the error to for this field.
	// @return self
	//
	public function setError (Error|string $error) {
		if ($error instanceof Error) {
			$this->error = $error;
			return $this;
		} 
		
		$this->input = new Input($input);
		return $this;
	}

	
	// Error
	//
	// @alias setError
	// @param Error|string $error - The error component or input name to associate the error to for this field.
	// @return self
	//
	public function error (Error|string $error): self {
		return $this->setError($error);
	}


	// Get Error 
	//
	// @return Error|false
	//
	public function getError (): Error|false {
		return $this->error;
	}

	
}