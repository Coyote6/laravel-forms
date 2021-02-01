<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;
use Coyote6\LaravelForms\Traits\ConfirmationField;


class Password extends Input {
	
	use ConfirmationField;
	
	
	const CONFIRMATION_FIELD = 'password';
	
	
	protected $type = 'password';
	protected $defualtRules = ['string'];
	
		
}


