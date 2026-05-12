<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Illuminate\Support\Collection;


trait FieldRules {
		

	// Rules
	//
	// Return the rules collection.
	//
	// @return Collection
	//
	public function rules (): Collection {
		if ($this->input === false) {
			return collect();
		}
		return $this->input->rules;
	}
	

	public function validateInputSet (): void {
		if ($this->input === false) {
			trigger_error('An input must be set on the field prior to adding any rules.');
		}
	}


	public function addRule (mixed $rule, $ruleName = null): self {

		$this->validateInputSet();
		$this->input->addRule ($rule, $ruleName);
		return $this;

	}
	
	
	public function addRules (Collection|array $rules): self {
		
		$this->validateInputSet();
		$this->input->addRules ($rules);
		return $this;
	
	}
	
	
	public function removeRule ($ruleName): self {
	
		$this->validateInputSet();
		$this->input->removeRule ($ruleName);
		return $this;

	}
	
	
	
	// Is Required
	// 
	// @return bool
	//
	public function isRequired (): bool {
		
		$this->validateInputSet();
		return $this->input->isRequired();

	}
	
	
	// Required
	//
	// Set the field input to required.
	//
	// @return self
	//
	public function required (): self {
		
		$this->validateInputSet();
		$this->input->required();
		if ($this->label) {
			$this->label->fieldIsRequired();
		}
		return $this;

	}


	// Require
	//
	// @alias required
	// @return self
	//
	public function require (): self {
		return $this->required();
	}
	
	
	// Nullable
	//
	// Removes the required rule and attribute from the input.
	//
	// @return self
	//
	public function nullable (): self {

		$this->validateInputSet();
		$this->input->nullable();
		if ($this->label) {
			$this->label->fieldIsNotRequired();
		}
		return $this;

	}


	// Not Required
	//
	// @alias required
	// @return self
	//
	public function notRequired (): self {
		return $this->nullable();
	}


	// Disabled
	//
	// Sets the disabled attribute on the field input, which will disable the field in the browser.
	//
	// @return self
	//
	public function disabled (): self {

		$this->validateInputSet();
		$this->input->disabled();
		return $this;
		
	}
	

	// Disable
	//
	// Alias for disable, but more intuitive for some fields.
	//
	// @alias disable
	// @return self
	//
	public function disable (): self {
		return $this->disabled();
	}
	

	// Enabled
	//
	// Removes the disabled attribute from the field input, which will enable the field in the browser.
	//
	// @return self
	//
	public function enabled (): self {

		$this->validateInputSet();
		$this->input->enabled();
		return $this;
	}
	

	// Enable
	//
	// Alias for enable, but more intuitive for some fields.
	//
	// @alias enable
	// @return self
	//
	public function enable (): self {
		return $this->enabled();
	}

	
	
}
