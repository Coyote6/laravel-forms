<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait Suffix {
	

	public string $suffix = '';
	protected $appendSuffix = false;
	
	
	public function suffix (string $value) {
		$this->suffix = $value;
		return $this;
	}
	
	
	public function appendSuffix () {
		$this->appendSuffix = true;
		return $this;
	}
	
	
	public function tempAppendSuffix () {
		$this->appendSuffix = 'temp';
		return $this;
	}
	
	
	public function shouldAppend () {
		if ($this->appendSuffix == false) {
			return false;
		}
		return true;
	}
	
	public function isTempAppend () {
		if ($this->appendSuffix == 'temp') {
			return true;
		}
		return false;
	}
	

}