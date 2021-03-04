<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;
use Coyote6\LaravelForms\Form\Option;
use Coyote6\LaravelForms\Traits\Options;
use Illuminate\Validation\Rule;


class Select extends Field {
	
	protected $type = 'select';
	protected $template = 'select';


	use Options;	
	
	
	protected function defaultRules() {
		return ['nullable'];
	}
	
	public function rules () {
		$this->rules['in'] = Rule::in($this->optionValues());
		return $this->rules;
	}

		
	public function renderAttributes () {		
		$this->addAttribute ('name', $this->name);
		return parent::renderAttributes();
	}
	
	
	protected function prerender () {
		
		$val = old ($this->name, $this->value);
		
		$hasDefault = false;
		foreach ($this->options as $o) {
			if ($o->value == $val) {
				$o->addAttribute('selected');
			}
			if ($o->value == '') {
				$hasDefault = true;
			}
		}
		
		if (!$hasDefault) {
			$default = new Option();
			$default->value = '';
			$default->label = '-- Please Select --';
			array_unshift($this->options, $default);
		}
		
		$this->labelTag->addAttribute ('for', $this->name);
		$this->addAttribute ('id', $this->name);
	
	}
	
	
	public function templateVariables () {
		$vars = parent::templateVariables();
		$vars += ['options' => $this->options()];
		return $vars;
	}
		
}


