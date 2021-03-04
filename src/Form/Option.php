<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;
use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\Render;
use Coyote6\LaravelForms\Traits\Weighted;


class Option {


	use Attributes, Weighted, Render;
	
	
	protected $template = 'option';
	
	public $value;
	public $label = false;
	
	
	protected function prerender () {
		$this->addAttribute ('value', $this->value);
	}	
	
	
	protected function templateVariables () {
		return [
			'attributes' => $this->renderAttributes(),
			'label' => __($this->label) // Translate the label
		];
	}

	
}
