<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;


class Html extends Field {
	
	protected $type = 'html';
	protected $template = 'html';
		
	
	public function templateVariables () {
	
		$vars = parent::templateVariables();
		$vars += ['content' => $this->value];

		return $vars;		
		
	}
}


