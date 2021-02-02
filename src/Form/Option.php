<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;
use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\Weighted;


class Option {


	use Attributes, Weighted;
	
	
	public $value;
	public $label = false;
	
	
	public function __toString() {
		return $this->generateHtml();
	}
	
	
	public function renderAttributes () {
		$attrs = [];
		if (!empty ($this->classes)) {
			$attrs[] = 'class="' . implode (' ', $this->classes) . '"';
		}
		$attrs[] = 'value="' . $this->value . '"';
		foreach ($this->attributes as $name => $value) {
			if (!in_array ($name, ['name', 'class'])) {
				if (in_array ($name, ['checked', 'required', 'multiple']) && $value) {
					$attrs[] = $name;
				}
				else {
					$attrs[] = $name . '="' . str_replace ('"', '\"', $value) . '"';
				}
			}
		}
		return implode (' ', $attrs);
	}

	
	public function generateHtml () {

		$vars = [
			'attributes' => $this->renderAttributes(),
			'value' => $this->value,
			'label' => __($this->label) // Translate the label
		];
		
		$template = 'forms.option';
		if (!view()->exists ($template)) {
      $template = 'laravel-forms::' . $template;
    }
		return view ($template, $vars)->render();
	
	}
	
	
	public function render () {
		print $this->generateHtml();
	}
	
}
