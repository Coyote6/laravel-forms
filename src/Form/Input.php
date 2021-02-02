<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;


abstract class Input extends Field {
	
	
	protected $type = 'input';
	protected $template = 'input';
	
	
	public function __construct (string $name) {
		parent::__construct ($name);
		$this->addClass ('input');
	}
	
	
	public function renderAttributes () {
		
		$attrs = [];
		if (!empty ($this->classes)) {
			$attrs[] = 'class="' . implode (' ', $this->classes) . '"';
		}
		$attrs[] = 'id="' . str_replace ('"', '\"', $this->name) . '"';
		$attrs[] = 'type="' . str_replace ('"', '\"', $this->type) . '"';
		$attrs[] = 'name="' . str_replace ('"', '\"', $this->name) . '"';
		$attrs[] = 'value="' . str_replace ('"', '\"', $this->value) . '"';
		
		foreach ($this->attributes as $name => $value) {

			if (!in_array ($name, ['name', 'value', 'default', 'id', 'type', 'class'])) {
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
	
}


