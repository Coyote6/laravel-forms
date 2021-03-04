<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;


class Radio extends Input {
	
	protected $type = 'radio';
	protected $template = 'input--radio';
	
		
	protected function defaultRules() {
		return [];
	}

	
	protected function prerender () {
		
		parent::prerender();
		
		$oldVal = old ($this->name);
		if ($oldVal == $this->value) {
			$this->addAttribute('checked');
		}
		
		$this->addAttribute ('id', $this->name . '--' . $this->value);
		$this->labelTag->addAttribute ('for', $this->name . '--' . $this->value);		

	}
		
}


