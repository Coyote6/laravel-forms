<?php
	
	
namespace Coyote6\LaravelForms\Traits;


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
	
	
	public function isKnownRule ($val) {
		if (is_object ($val)) {
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
	
	
	public function addRules (array $rules) {
		
		foreach ($rules as $rule) {
			if (is_string ($rule) || $this->isKnownRule ($rule)) {
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
