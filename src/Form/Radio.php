<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;


class Radio extends Input {
	
	protected $type = 'radio';
	protected $template = 'input--reversed';
		
	public function renderAttributes () {
		
		$attrs = [];
		if (!empty ($this->classes)) {
			$attrs[] = 'class="' . implode (' ', $this->classes) . '"';
		}
		$attrs[] = 'id="' . str_replace ('"', '\"', $this->name . '--' . $this->value) . '"';
		$attrs[] = 'type="radio"';
		$attrs[] = 'name="' . str_replace ('"', '\"', $this->name) . '"';
		$attrs[] = 'value="' . str_replace ('"', '\"', $this->value) . '"';
		
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
		
		$oldVal = old ($this->name);
		if ($oldVal == $this->value) {
			$this->addAttribute('checked');
		}
		
		if ($this->template) {
			$vars = [
				'attributes' => $this->renderAttributes(),
				'value' => $this->value,
				'label' => $this->label,
				'id' => $this->name . '--' . $this->value,
				'name' => $this->name,
				'type' => $this->type
			];
			
			$template = 'forms.' . $this->template;
			if (!view()->exists ($template)) {
        $template = 'laravel-forms::' . $template;
      }
			return view ($template, $vars);

		}
	}
		
}


