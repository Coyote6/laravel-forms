<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;


class Button extends Field {
	
	
	protected $type = 'button';
	protected $template = 'button';
	
	public $content = false;
	
	
	public function __construct (string $name) {
		$this->classes = ['button'];
		$this->name = $name;
	}
	
	
	public function renderAttributes () {
		
		$attrs = [];
		if (!empty ($this->classes)) {
			$attrs[] = 'class="' . implode (' ', $this->classes) . '"';
		}
		$attrs[] = 'id="' . str_replace ('"', '\"', $this->name) . '"';
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
		
		if (!is_string ($this->content)) {
			$this->content = $this->value;
		}
		
		if (is_string ($this->content)) {
			$allowed = '<span><br><strong><em><b><i><img>';
			// Run twice just in case someone splits tags such as '<s<div>cript>alert(1);</s<div>cript>'.
			// This is not full proof just an extra catch.
			//
			$this->content = strip_tags (strip_tags ($this->content, $allowed), $allowed); 
		}
		
		if ($this->template) {
			$vars = [
				'attributes' => $this->renderAttributes(),
				'value' => $this->value,
				'label' => $this->label,
				'id' => $this->name,
				'name' => $this->name,
				'type' => $this->type,
				'content' => $this->content
			];
			
			$template = 'forms.' . $this->template;
			if (!view()->exists ($template)) {
        $template = 'laravel-forms::' . $template;
      }
			return view ($template, $vars)->render();
		}
	}
	
	
}
