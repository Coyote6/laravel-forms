<?php
	
	
namespace Coyote6\LaravelForms\Traits;



trait ConfirmationField {
	

	protected static function confirmationFieldName () {
		$rClass = new \ReflectionClass(static::class);
		$class = $rClass->getShortName();
		return lcfirst ($class);
	}

	public function confirm ($form) {
		return $this->addConfirmationField ($form);
	}
	
	public function addConfirm ($form) {
		return $this->addConfirmationField ($form);
	}

	public function addConfirmationField ($form) {
		$name = $this->name . '_confirmation';
		$field = static::confirmationFieldName();
		$pcf = $form->$field ($name);
		$this->addRule('confirmed');
		if (is_string ($this->label) && $this->label != '') {
			$pcf->label = 'Confirm ' . $this->label;
		}
		return $pcf;
	}	
	
}
