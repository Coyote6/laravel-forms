<?php

namespace Coyote6\LaravelForms\Fields;


use Coyote6\LaravelForms\Fields\Field;


class Textarea extends Field {

    public function __construct (string $name) {
		$this->name = $name;
		$this->setInput ($name);
	}

	// Allow only Textarea Inputs.
	protected function allowedInputComponents (): array {
		return ['Textarea'];
	}


	// Set Textarea
	//
	// @alias setInput
	// @param Textarea|string $input - The input component or text to display for this field.
	// @return self
	//
	public function setTextarea (Textarea|string $input): self {
		return $this->setInput($input);
	}


	// Get Textarea
	//
	// @return Textarea|false
	//
	public function getTextarea (): Textarea|false {
		return $this->getInput();
	}

}