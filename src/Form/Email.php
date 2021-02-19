<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Text;
use Coyote6\LaravelForms\Traits\ConfirmationField;


class Email extends Text {
	
	
	use ConfirmationField;
	
	
	protected $type = 'email';


	protected function defaultRules () {
		return ['string', 'email'];
	}	

	
}


