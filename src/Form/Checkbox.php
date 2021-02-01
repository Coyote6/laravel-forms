<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;
Use Illuminate\Validation\Rule;


class Checkbox extends Input {

	
	protected $type = 'checkbox';
	protected $template = 'input--reversed';
	
	
	public function __get ($name) {
		if ($name == 'rules' && !isset ($this->rules['in'])) {
			$this->rules['in'] = Rule::in([$this->value]);
		}
		return parent::__get ($name);
	}

	public function generateHtml () {
		
		$val = old ($this->name, $this->value);
		if ($val == $this->value) {
			$this->addAttribute('checked');
		}
		return parent::generateHtml();
		
	}


}


