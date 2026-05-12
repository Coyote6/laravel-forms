<?php


namespace Coyote6\LaravelForms\Components;


use Coyote6\LaravelForms\Traits\InputAttributes;
use Coyote6\LaravelForms\Traits\LivewireModelComponent;
use Coyote6\LaravelForms\Traits\Render;
use Coyote6\LaravelForms\Traits\Rules;


class Input {

    use InputAttributes,
		LivewireModelComponent,
        Render,
		Rules;

	protected string $name;
	protected string $defaultThemeSubdirectory = '.components';
	protected string $defaultComponent = 'input';


    public function __construct (?string $name = null) {
		if (is_string ($name) && trim($name) != '') {
			$this->name = $name;							// Needed for Livewire
			$this->addAttr ('name', $name);
		}
	}


	protected function prerender () {
		$this->addTemplateVariables ([
			'attributes' => $this->getAttributes(),
		]);
	}


	// Set Name
	//
	// Get the input's name.
	//
	// @param string $name - The name of the input
	// @return self
	//
	public function setName (string $name): self {
		$this->name = $name;
		$this->addAttr ('name', $name);
		return $this;
	}

	// Get Name
	//
	// Get the input's name.
	//
	// @return string|null
	//
	public function getName (): string|null {
		return $this->name;
	}

	

   

}