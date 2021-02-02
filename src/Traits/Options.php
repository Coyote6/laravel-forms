<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\Option;


trait Options {
	
	protected $options = [];
	

	public function addOption (string $value, string $label) {
		
		$o = new Option ();
		$o->value = $value;
		$o->label = $label;
		$this->options[$value] = $o;
		return $o;
		
	}
	
	public function addOptions (array $options) {
		foreach ($options as $value => $label) {
			$this->addOption ($value, $label);
		}
	}
	
	public function setOptions (array $options) {
		$this->addOptions ($options);
	}
	
	public function removeOption (string $value) {
		if (isset ($this->options[$value])) {
			unset ($this->options[$value]);
		}
	}
	
	public function options () {
		return $this->options;
	}
	
	public function optionValues () {
		$vals = [];
		foreach ($this->options as $value => $label) {
			$vals[] = $value;
		}
		return $vals;
	}
	
}