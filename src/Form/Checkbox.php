<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;
Use Illuminate\Validation\Rule;


class Checkbox extends Input {

	
	protected $type = 'checkbox';
	protected $template = 'input--checkbox';
	
	
	public function rules () {
		$vals = [$this->value];
		if (!isset ($this->rules['required'])) {
			$vals[] = '';
		}
		$this->rules['in'] = Rule::in($vals);
		return $this->rules;
	}
	

	protected function prerender () {
		
		$val = old ($this->name);
		if ($val == $this->value) {
			$this->addAttribute('checked');
		}
		
		parent::prerender();
	
	}


}


