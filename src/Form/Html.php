<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;


class Html extends Field {
	
	protected $type = 'html';
	protected $template = 'html';
	
	public $content = false;
	
	public function templateVariables () {
		
		if (is_string ($this->content) && $this->content != '') {
			$this->value = $this->content;
		}
					
		$vars = parent::templateVariables();
		$vars += ['content' => $this->value];

		return $vars;		
		
	}
	
	
	public function content (string $content) {
		$this->content = $content;
		return $this;
	}
	
}


