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
	
	
	public function __get ($name) {
		if ($name == 'rules' && !isset ($this->rules['in'])) {
			$this->rules['in'] = Rule::in($this->optionValues());
		}
		return parent::__get ($name);
	}

		
	public function renderAttributes () {
		
		$attrs = [];
		
		if (!empty ($this->classes)) {
			$attrs[] = 'class="' . implode (' ', $this->classes) . '"';
		}
		
		$attrs[] = 'id="' . str_replace ('"', '\"', $this->name . '--' . $this->value) . '"';
		$attrs[] = 'name="' . str_replace ('"', '\"', $this->name) . '"';
		
		foreach ($this->attributes as $name => $value) {

			if (!in_array ($name, ['name', 'value', 'default', 'id', 'type', 'class'])) {
				if ($name == 'checked' || $name == 'required') {
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
				
		if ($this->template) {
			$vars = [
				'attributes' => $this->renderAttributes(),
				'value' => $val,
				'label' => $this->label,
				'id' => $this->name . '--' . $this->value,
				'name' => $this->name,
				'type' => $this->type,
				'options' => $this->options()
			];
			
			$template = 'forms.' . $this->template;
			if (!view()->exists ($template)) {
        $template = 'laravel-forms::' . $template;
      }
			return view ($template, $vars);
			
		}
	}
		
}


