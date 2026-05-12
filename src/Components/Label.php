<?php


namespace Coyote6\LaravelForms\Components;

use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\HtmlContent;
use Coyote6\LaravelForms\Traits\LivewireModelComponent;
use Coyote6\LaravelForms\Traits\Render;


class Label {

    use Attributes,
		HtmlContent,
		LivewireModelComponent,
		Render;

	protected string $defaultThemeSubdirectory = '.components';
	protected string $defaultComponent = 'label';
	protected bool $required = false;

    public function __construct (string $content = '') {
		$this->setContent($content);	
	}

	protected function prerender () {
		$this->addTemplateVariables ([
			'attributes' => $this->getAttributes(),
			'content' => $this->getContent(),
			'displayRequiredTag' => config('forms.display--required-tag', true),
			'isRequired' => $this->required
		]);
	}

	public function fieldIsRequired () {
		$this->required = true;
	}

	public function fieldIsNotRequired () {
		$this->required = false;
	}

   

}