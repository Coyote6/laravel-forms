<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Text;


class Email extends Text {	
	
	protected $type = 'email';
	protected $template = 'email';

	protected function defaultRules () {
		return ['string', 'email'];
	}	
	
}


