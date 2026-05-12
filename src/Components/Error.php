<?php


namespace Coyote6\LaravelForms\Components;

use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\LivewireModelComponent;
use Coyote6\LaravelForms\Traits\Render;

class Error {

	use Attributes,
		LivewireModelComponent,
		Render;

    protected string $name;
	protected string $defaultThemeSubdirectory = '.components';
	protected string $defaultComponent = 'error';

    public function __construct (string $name) {
		$this->name = $name;
	}


	protected function prerender () {		
		$this->addTemplateVariables ([
			'attributes' => $this->getAttrsExcept('name'),
			'name' => $this->name
		]);
	}

   

}