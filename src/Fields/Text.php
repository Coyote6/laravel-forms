<?php

namespace Coyote6\LaravelForms\Fields;

use Coyote6\LaravelForms\Fields\Field;


class Text extends Field {


    public function __construct (string $name) {
		$this->name = $name;
		$this->setInput ($name);
	}

    // Allow only Text Inputs.
	protected function allowedInputComponents (): array {
		return ['Input'];
	}

}