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
	

	public function addConfirmationField (string $confirmationFieldLivewireProperty = null) {
		
		$this->confirmFieldName = $this->name . '_confirmation';
		$field = static::confirmationFieldName();
		$cf = $this->parent->$field ($this->confirmFieldName);
		
		$this->addAttribute('data-model', $this->getLw());

		$this->addRule('confirmed');
		$this->hasConfirmField = true;

		$cf->addAttribute('wire:keyup', '$emit(\'updatedConfirmation\',\'' . $this->id . '\')');
		$cf->addAttribute('wire:blur', '$emit(\'updatedConfirmation\',\'' . $this->id . '\')');
		
		if ($this->getLw() != '' && !is_null ($confirmationFieldLivewireProperty) && $confirmationFieldLivewireProperty != '') {
			$cf->setLwLoadMethod ($this->getLwLoadMethod(), $confirmationFieldLivewireProperty, $this->getLwDebounceDelay());
		}
		
		if (is_string ($this->label) && $this->label != '') {
			$cf->label = 'Confirm ' . $this->label;
		}
		
		if ($this->hasAttribute('placeholder')) {
			$cf->placeholder ('Confirm ' . $this->getAttr('placeholder'));
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
