<?php
	
	
namespace Coyote6\LaravelForms\Traits;



trait ConfirmationField {
	

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
		$name = $this->name . '_confirmation';
		$field = static::confirmationFieldName();
		$pcf = $this->parent->$field ($name);
		$this->addRule('confirmed');
		if (is_string ($this->label) && $this->label != '') {
			$pcf->label = 'Confirm ' . $this->label;
		}
		return $pcf;
	}	
	
	
}
