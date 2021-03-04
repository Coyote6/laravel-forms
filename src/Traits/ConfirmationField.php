<?php
	
	
namespace Coyote6\LaravelForms\Traits;



trait ConfirmationField {
	
	
	protected $confirmFieldName;
	protected $hasConfirmField = false;
	

	protected static function confirmationFieldName () {
		$rClass = new \ReflectionClass(static::class);
		$class = $rClass->getShortName();
		return lcfirst ($class);
	}
	

	public function confirm () {
		return $this->addConfirmationField();
	}
	
	
	public function addConfirm () {
		return $this->addConfirmationField();
	}
	

	public function addConfirmationField () {
		
		$this->confirmFieldName = $this->name . '_confirmation';
		$field = static::confirmationFieldName();
		$cf = $this->parent->$field ($this->confirmFieldName);
		
		$this->addRule('confirmed');
		$this->hasConfirmField = true;

		$cf->addAttribute('wire:keyup', '$emit(\'updatedConfirmation\',\'' . $this->name . '\')');
		$cf->addAttribute('wire:blur', '$emit(\'updatedConfirmation\',\'' . $this->name . '\')');
		
		if (is_string ($this->label) && $this->label != '') {
			$cf->label = 'Confirm ' . $this->label;
		}
		
		return $cf;
	}	
	
	
	public function hasConfirmField () {
		return $this->hasConfirmField;
	}
	
	
	public function confirmFieldName () {
		return $this->confirmFieldName;
	}
	
	
}
