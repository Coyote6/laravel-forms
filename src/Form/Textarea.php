<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;


class Textarea extends Field {
	
	protected $type = 'textarea';
	protected $template = 'textarea';
	protected $defualtRules = ['string'];
	
}