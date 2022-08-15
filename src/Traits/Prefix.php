<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait Prefix {
	
	
	public string $prefix = '';
	protected $prependPrefix = false;

	
	public function prefix (string $value) {
		$this->prefix = $value;
		return $this;
	}
	
	
	public function prependPrefix () {
		$this->prependPrefix = true;
		return $this;
	}
	
	
	public function tempPrependPrefix () {
		$this->prependPrefix = 'temp';
		return $this;
	}
	
	
	public function shouldPrepend () {
		if ($this->prependPrefix == false) {
			return false;
		}
		return true;
	}
	
	public function isTempPrepend () {
		if ($this->prependPrefix == 'temp') {
			return true;
		}
		return false;
	}
	
	
}