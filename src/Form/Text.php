<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;
use Coyote6\LaravelForms\Traits\ConfirmationField;


class Text extends Input {
	
	
	use ConfirmationField;


	protected $type = 'text';
	protected $template = 'text';


	protected function defaultRules() {
		return ['nullable', 'string'];
	}
	
	
	protected function prerender () {
		$this->value = old ($this->name, $this->value);
		parent::prerender();
	}
	
}


