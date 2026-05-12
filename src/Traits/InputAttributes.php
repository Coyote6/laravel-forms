<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Traits\DisabledAttributes;


trait InputAttributes {
	

	use DisabledAttributes;
	
	
	// Placeholder
	//
	// Set the placeholder attribute for this input field. If no value is provided, it will default to the field's label or name.
	//
	// @param string|null $value - The value to set for the placeholder attribute. If null or empty, it will default to the field's label or name.
	// @return self
	//
	public function placeholder (?string $value = null): self {
		if (is_null ($value) || $value == '') {
			if (isset ($this->label) && $this->label !== false) {
				$value = $this->label;
			}
			else {
				$value = ucfirst ($this->name);
			}
		}
		return $this->setAttribute ('placeholder', $value);
	}

	
	// Autocomplete
	//
	// Set the autocomplete attribute for this input field. If no value is provided, it will default to the field's name.
	//
	// @param string|null $value - The value to set for the autocomplete attribute. If null or empty, it will default to the field's name.
	// @return self
	//
	public function autocomplete (?string $value = null): self {
		if (is_null ($value) || $value == '') {
			$value = $this->name;
		}
		return $this->setAttribute ('autocomplete', $value);
	}
	
	
}