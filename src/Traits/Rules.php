<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\DatabaseRule;
use Illuminate\Validation\Rules\Dimensions;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\NotIn;
use Illuminate\Validation\Rules\RequireIf;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;



trait Rules {
	
	
	// Set the property to store the rules.
	protected Collection|false $rules = false;
	

	// Check Initialized Rules
	//
	// This method checks if the $rules property has been initialized as a collection. If it has not, it initializes it. 
	// This is used to ensure that the $rules property is always a collection when it is used.
	//
	protected function checkInitializedRules (): void {
		if ($this->rules === false) {
			$this->rules = collect();
		}
	}
	

	// Rules
	//
	// Return the rules collection.
	//
	// @return Collection
	//
	public function rules (): Collection {
		$this->checkInitializedRules();
		return $this->rules;
	}
	
	
	// Get Rule Name
	//
	// Get the rule name from the rule string.
	//
	// @param string $rule - The string that builds the rule.
	// @return string|false
	//
	protected function getRuleName (string $rule): string|false {
		if (!is_string ($rule)) {
			return false;
		}
		$parts = explode(':', $rule);
		return $parts[0];
	}
	
	
	// Is Known Rule
	//
	// @param mixed $val - The rule to check if it is a known type
	// @return bool
	//
	protected function isKnownRule (mixed $val): bool {
		if (is_object ($val)) {
			if ($val instanceof Rule) {
				return true;
			}
			if ($val instanceof Unique) {
				return true;
			}
			if ($val instanceof Password) {
				return true;
			}
			if ($val instanceof Enum) {
				return true;
			}
			if ($val instanceof In) {
				return true;
			}
			if ($val instanceof NotIn) {
				return true;
			}
			if ($val instanceof RequireIf) {
				return true;
			}
			if ($val instanceof Exists) {
				return true;
			}
			
			if ($val instanceof DatabaseRule) {
				return true;
			}
			if ($val instanceof Dimensions) {
				return true;
			}
		}
		return false;
	}


	public function addRule (mixed $rule, $ruleName = null) {

		$this->checkInitializedRules();
		
		// Check for known string.
		if (is_string ($rule)) {
			
			if ($rule == 'required') {
				$this->required();
			}
			else if ($rule == 'nullable') {
				$this->nullable();
			}
			else if ($rule == 'sometimes') {
				$this->sometimes();
			}
		
			// Get the rule name from the string if not set explicitly
			if (!is_string ($ruleName)) {
				$ruleName = $this->getRuleName ($rule);
			}

			$this->rules[$ruleName] = $rule;
		
		}
		else if ($this->isKnownRule ($rule)) {
			if (is_string ($ruleName)) {
				$this->rules[$ruleName] = $rule;
			}
			else {
				$this->rules[] = $rule;
			}
		}
		return $this;
	}
	
	
	public function addRules (Collection|array $rules) {
		
		foreach ($rules as $rule) {
			if (is_string ($rule) || $this->isKnownRule ($rule)) {
				$this->addRule ($rule);
			}
		}
		return $this;
	
	}
	
	
	public function removeRule ($ruleName) {
	
		$this->checkInitializedRules();

		if (
			(is_string ($ruleName) || is_int ($ruleName)) &&
			isset ($this->rules[$ruleName])
		) {
			unset ($this->rules[$ruleName]);
		}
		return $this;

	}
	
	
	
	// Is Required
	// 
	// @return bool
	//
	public function isRequired (): bool {
		
		$this->checkInitializedRules();

		if ($this->rules->has('required')) {
			return true;
		}
		return false;
	}
	
	
	// Required
	//
	// Set the field to required.
	//
	// @return self
	//
	public function required (): self {
		
		$this->checkInitializedRules();

		if ($this->rules->has('nullable')) {
			$this->rules->forget('nullable');
		}
		$this->rules->put('required', 'required');

		if (is_callable([$this, 'addAttribute'])) {
			$this->addAttribute ('required');
		}

		return $this;
	}


	// Require
	//
	// @alias required
	// @return self
	//
	public function require (): self {
		$this->addRulesFromOutside('required');
		return $this->required();
	}
	
	
	// Nullable
	//
	// Removes the required rule and attribute.
	//
	// @return self
	//
	public function nullable (): self {

		$this->checkInitializedRules();
	
		if ($this->rules->has('required')) {
			$this->rules->forget('required');
		}
		$this->rules->put('nullable', 'nullable');

		if (is_callable([$this, 'removeAttribute'])) {
			$this->removeAttribute ('required');
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
	// Sets the disabled attribute on the field, which will disable the field in the browser.
	//
	// @return self
	//
	public function disabled (): self {

		$this->checkInitializedRules();

		$this->rules->put('prohibited', 'prohibited');

		if (is_callable([$this, 'addAttribute'])) {
			$this->setAttribute ('disabled', true);
		}

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
	// Removes the disabled attribute from the field, which will enable the field in the browser.
	//
	// @return self
	//
	public function enabled (): self {

		$this->checkInitializedRules();

		if ($this->rules->has('prohibited')) {
			$this->rules->forget('prohibited');
		}

		if (is_callable([$this, 'removeAttribute'])) {
			$this->removeAttribute ('disabled');
		}
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
