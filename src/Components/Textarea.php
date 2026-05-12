<?php


namespace Coyote6\LaravelForms\Components;


use Coyote6\LaravelForms\Traits\InputAttributes;
use Coyote6\LaravelForms\Traits\HtmlContent;
use Coyote6\LaravelForms\Traits\LivewireModel;
use Coyote6\LaravelForms\Traits\Render;
use Coyote6\LaravelForms\Traits\Rules;


class Textarea {

    use InputAttributes,
		HtmlContent,
		LivewireModel,
        Render,
		Rules;

	protected string $name;
	protected string $defaultThemeSubdirectory = '.components';
	protected string $defaultComponent = 'textarea';

	// Dev Note:
	//		$content is overridden if a Livewire model is set.
	//		
    public function __construct (?string $name = null, string $content = '') {
		if (is_string ($name)) {
			$name = trim($name);
			if ($name != '') {
				$this->name = $name;							// Needed for Livewire
				$this->addAttr ('name', $name);
			}
		}
		$this->setContent($content);	
	}


	protected function prerender () {
		$this->addTemplateVariables ([
			'attributes' => $this->getAttributes(),
			'content' => $this->getContent()
		]);
	}

   

}