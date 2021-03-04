<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;


abstract class Input extends Field {
	
	
	protected $type = 'input';
	protected $template = 'input';
	
	
	public function __construct (string $name) {
		parent::__construct ($name);
		if ($this->defaultClasses) {
			$this->addClass ('input');
		}
	}
	
	
	protected function defaultRules() {
		return ['nullable'];
	}
	
	
	protected function prerender () {

		$this->addAttribute ('name', $this->name);
		$this->addAttribute ('type', $this->type);
		$this->addAttribute ('value', $this->value);
		
	}
	
}


