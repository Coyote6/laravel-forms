<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;


class Button extends Field {
	
	
	protected $type = 'button';
	protected $template = 'button';
	
	public $content = false;
	
	
	public function __construct (string $name) {
		parent::__construct ($name);
		if ($this->defaultClasses) {
			$this->addClass ('button');
		}
	}
	

	protected function prerender () {
		
		$this->addAttribute ('name', $this->name);
		$this->addAttribute ('type', $this->type);
		$this->addAttribute ('value', $this->value);

		$this->value = old ($this->name, $this->value);
		
		// Add a default value if we are to render as a button.
		if ($this->template == 'button' && !is_string ($this->content)) {
			$this->content = $this->value;
		}
		
		if (is_string ($this->content)) {
			$allowed = '<span><br><strong><em><b><i><img>';
			// Run twice just in case someone splits tags such as '<s<div>cript>alert(1);</s<div>cript>'.
			// This is not full proof just an extra catch.
			//
			$this->content = strip_tags (strip_tags ($this->content, $allowed), $allowed); 
		}
				
		$this->labelTag->addAttribute ('for', $this->name);
		$this->addAttribute ('id', $this->name);
						
	}
	
	
	protected function templateVariables () {
		$vars = parent::templateVariables();
		$vars += ['content' => ($this->template == 'button') ? $this->content : false];
		return $vars;
	}
	
	
}
