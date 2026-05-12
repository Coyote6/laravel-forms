<?php


namespace Coyote6\LaravelForms\Components;


use Coyote6\LaravelForms\Traits\InputAttributes;
use Coyote6\LaravelForms\Traits\LivewireModel;
use Coyote6\LaravelForms\Traits\Render;
use Coyote6\LaravelForms\Traits\Rules;


class Input {

    use InputAttributes,
		LivewireModel,
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

   

}