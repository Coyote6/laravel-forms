<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;
Use Illuminate\Validation\Rule;


class Checkbox extends Input {

	
	protected $type = 'checkbox';
	protected $template = 'checkbox';
	
	
	public function rules () {
		
		if (is_null ($this->value)) {
			$this->value = true;
		}
		
		if (is_bool ($this->value)) {
			$vals[] = true;
		}
		else if (is_string ($this->value)) {
			$vals = [$this->value];
		}
		
		if (!isset ($this->rules['required'])) {
			if (is_string ($this->value)) {
				$vals[] = '';
			}
			else {
				$vals[] = false;
			}

		}
		else {
			$this->rules['accepted'] = 'accepted';
		}
		
		$this->rules['in'] = Rule::in($vals);
		return $this->rules;
	}
	

	protected function prerender () {
		
		$val = old ($this->name);
		if (!is_null ($val) && $val == $this->value) {
			$this->addAttribute('checked');
		}
		
		if (is_null ($this->value)) {
			$this->value = 1;
		}
		
		parent::prerender();
	
	}


}


