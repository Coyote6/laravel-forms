<?php
	
	
namespace Coyote6\LaravelForms\Traits;

use Coyote6\LaravelForms\Components\Email;
use Coyote6\LaravelForms\Components\Input;
use Coyote6\LaravelForms\Components\Textarea;


trait HasInput {

	protected Input|Email|Textarea|false $input = false;

	public const array ALLOWED_INPUT_COMPONENTS = [
		'Input' => Input::class,
		'Email' => Email::class,
		'Textarea' => Textarea::class,
	];

	// Allowed Input Components
	//
	// Abstract function that must set the list of allowed components.
	// 
	// @return [] - Example: ['Input','Textarea']
	//
	abstract protected function allowedInputComponents (): array;


	// Validate Input Set
	//
	// Ensure that the input is set and throw an error if not.
	//
	// @param string $errorMessage - The message to display to the developer.
	// @return void
	//
	public function validateInputSet (string $errorMessage = 'An input must be set.'): void {
		if ($this->input === false) {
			trigger_error($errorMessage);
		}
	}

	
	
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
				$name = $this->input->getName();
				if ($name && is_callable ([$this, 'setInput'])) {
					$this->setError ($name);
				}
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
		if (is_callable ([$this, 'setInput'])) {
			$this->setError ($input);
		}

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