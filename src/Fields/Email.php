<?php

namespace Coyote6\LaravelForms\Fields;

use Coyote6\LaravelForms\Components\Email as Input;
use Coyote6\LaravelForms\Fields\Field;


class Email extends Field {


    public function __construct (string $name) {
		$this->name = $name . '--field';
		$this->inputName = $name;
		$email = new Input ($name);
		$this->setInput ($email);
	}

    // Allow only Text Inputs.
	protected function allowedInputComponents (): array {
		return ['Email'];
	}

}