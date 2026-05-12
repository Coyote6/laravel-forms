<?php


namespace Coyote6\LaravelForms\Fields;

use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\FieldRules;
use Coyote6\LaravelForms\Traits\HasDescription;
use Coyote6\LaravelForms\Traits\HasError;
use Coyote6\LaravelForms\Traits\HasInput;
use Coyote6\LaravelForms\Traits\HasLabel;
use Coyote6\LaravelForms\Traits\LivewireModel;
use Coyote6\LaravelForms\Traits\Render;


class Field {

    use Attributes,
		HasLabel,
		HasDescription,
		HasInput,
		HasError,
		LivewireModel,
		FieldRules,
        Render;

    protected string $name;
	protected string $defaultThemeSubdirectory = '.fields';
	protected string $defaultComponent = 'field';

    public function __construct (string $name) {
		$this->name = $name;
	}

	// Allow all types of inputs.
	protected function allowedInputComponents (): array {
		return array_keys(static::ALLOWED_INPUT_COMPONENTS);
	}

	protected function prerender () {
		$this->addTemplateVariables ([
			'attributes' => $this->getAttributes(),
			'label' => $this->label,
			'description' => $this->description,
			'input' => $this->input,
			'error' => $this->error,
		]);
	}

}