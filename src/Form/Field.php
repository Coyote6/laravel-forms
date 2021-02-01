<?php

namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\GroupedWithFormButtons;
use Coyote6\LaravelForms\Traits\Rules;
use Coyote6\LaravelForms\Traits\Weighted;


class Field {


	use Attributes, Weighted, Rules, GroupedWithFormButtons;
	
		
	protected $type;
	protected $name;
	protected $template;	
	
	public $value;
	public $label = false;
	
	
	public function __construct (string $name) {
		$this->classes = ['field'];
		$this->name = $name;
		$this->setDefaultRules();
	}
	
	public function __toString() {
		$this->render();
	}
	
	public function __get ($name) {
		if (in_array ($name, ['name', 'type', 'weight', 'template', 'rules'])) {
			return $this->$name;
		}
	}
	
	
	public function renderAttributes () {
		$attrs = [];
		if (!empty ($this->classes)) {
			$attrs[] = 'class="' . implode (' ', $this->classes) . '"';
		}
		$attrs[] = 'name="' . str_replace ('"', '\"', $this->name) . '"';
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
		$this->value = old ($this->name, $this->value);
		if ($this->template) {
			$vars = [
				'attributes' => $this->renderAttributes(),
				'value' => $this->value,
				'label' => __($this->label), // Translate the label
				'id' => $this->name,
				'name' => $this->name,
				'type' => $this->type
			];
			
			$template = 'forms.' . $this->template;
			if (!view()->exists ($template)) {
        $template = 'laravel-forms::' . $template;
      }
			return view($template, $vars);
		}
	}
	
	
	public function render () {
		print $this->generateHtml();
	}
	
	
}

