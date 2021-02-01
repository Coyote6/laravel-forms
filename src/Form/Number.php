<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;


class Number extends Input {
	
	protected $type = 'number';
	protected $defualtRules = ['numeric'];
		
}


