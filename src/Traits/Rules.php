<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Illuminate\Validation\Rule;


trait Rules {
	

	protected $rules = [];
	
	
	public function rules () {
		return $this->rules;
	}
	
	
	public function getRuleName ($rule) {
		if (!is_string ($rule)) {
			return false;
		}
		$parts = explode(':', $rule);
		return $parts[0];
	}


	public function addRule ($rule, $ruleName = null) {
		
		if (is_string ($rule)) {
			
			if ($rule == 'required') {
				$this->required();
			}
			else if ($rule == 'nullable') {
				$this->nullable();
			}
		
			if (!is_string ($ruleName)) {
				$ruleName = $this->getRuleName ($rule);
			}
			$this->rules[$ruleName] = $rule;
		
		}
		else if ($rule instanceof Rule) {
			if (is_string ($ruleName)) {
				$this->rules[$ruleName] = $rule;
			}
			else {
				$this->rules[] = $rule;
			}
		}
		return $this;
	}
	
	
	public function addRules (array $rules) {
		
		foreach ($rules as $rule) {
			if (is_string ($rule)) {
				$this->addRule ($rule);
			}
		}
		return $this;
	
	}
	
	
	public function removeRule ($ruleName) {
	
		if (
			(is_string ($ruleName) || is_int ($ruleName)) &&
			isset ($this->rules[$ruleName])
		) {
			unset ($this->rules[$ruleName]);
		}
		return $this;

	}
	
	
	// Return array of rules.
	abstract protected function defaultRules();
	
	public function setDefaultRules () {
		$this->addRules ($this->defaultRules());
		return $this;
	}
	
	
	public function isRequired () {
		if (isset ($this->rules['required'])) {
			return true;
		}
		return false;
	}
	
	
	public function required () {
		if (isset ($this->rules['nullable'])) {
			unset ($this->rules['nullable']);
		}
		$this->rules['required'] = 'required';
		if (is_callable([$this, 'addAttribute'])) {
			$this->addAttribute ('required');
		}
		return $this;
	}
	
	
	public function nullable () {
		if (isset ($this->rules['required'])) {
			unset ($this->rules['required']);
		}
		$this->rules['nullable'] = 'nullable';
		if (is_callable([$this, 'removeAttribute'])) {
			$this->removeAttribute ('required');
		}
		return $this;
	}
	
	
}
