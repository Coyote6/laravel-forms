<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;


class Text extends Input {
	
	protected $type = 'text';

	protected function defaultRules() {
		return ['nullable', 'string'];
	}
	
}


