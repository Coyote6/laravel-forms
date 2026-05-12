<?php
	
	
namespace Coyote6\LaravelForms\Traits;

use Coyote6\LaravelForms\Components\Input;
use Coyote6\LaravelForms\Components\Textarea;


trait HasInput {

	protected Input|Textarea|false $input = false;

	public const array ALLOWED_INPUT_COMPONENTS = [
		'Input' => Input::class,
		'Textarea' => Textarea::class,
	];

	// Allowed Input Components
	//
	// Abstract function that must set the list of allowed components.
	// 
	// @return [] - Example: ['Input','Textarea']
	//
	abstract protected function allowedInputComponents (): array;

	
	
	// Set Input
	//
	// @param mixed $input - The input component or text to display for this field.
	// @return self
	//
	public function setInput (mixed $input): self {

		//
		// Check all of the allowed input types.
		// Set it to the input type
		//
		$allowed = [];
		foreach ($this->allowedInputComponents() as $a) {
			if (isset (static::ALLOWED_INPUT_COMPONENTS[$a])) {
				$allowed[] = static::ALLOWED_INPUT_COMPONENTS[$a];
			}
		}

		foreach ($allowed as $a) {
			if ($input instanceof $a) {
				$this->input = $input;
				return $this;
			} 
		}

		// If anything other than a string is attached at this point, throw an error.
		if (!is_string ($input)) {
			$message = str_replace('[types]', implode(',', $allowed), 'Invalid input type attached to the [fieldName]field. Only an instance of an [types] maybe attached.');
			if (property_exists($this, 'name') && is_string ($this->name) && $this->name != '') {
				$message = str_replace('[fieldName]', $this->name . ' ', $message);
			}
			trigger_error ($message);
		}
		
		$this->input = new Input($input);
		return $this;
	}

	
	// Input
	//
	// @alias setInput
	// @param mixed $input - The input component or text to display for this field.
	// @return self
	//
	public function input (mixed $input): self {
		return $this->setInput($input);
	}


	// Get Input
	//
	// @return Input|false
	//
	public function getInput (): Input|Textarea|false {
		return $this->input;
	}

	
}