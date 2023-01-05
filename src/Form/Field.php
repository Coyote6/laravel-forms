<?php

namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Form;
use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\GroupedWithFormButtons;
use Coyote6\LaravelForms\Traits\HelpText;
use Coyote6\LaravelForms\Traits\LivewireModel;
use Coyote6\LaravelForms\Traits\Prefix;
use Coyote6\LaravelForms\Traits\Render;
use Coyote6\LaravelForms\Traits\Rules;
use Coyote6\LaravelForms\Traits\Suffix;
use Coyote6\LaravelForms\Traits\Tags;
use Coyote6\LaravelForms\Traits\Theme;
use Coyote6\LaravelForms\Traits\Weighted;


abstract class Field {


	use Attributes, 
		Weighted, 
		Rules, 
		GroupedWithFormButtons, 
		LivewireModel, 
		Theme, 
		Render, 
		Tags,
		Prefix,
		Suffix,
		HelpText;
	
		
	protected $type;
	protected $name;
	protected $template;
	
	public $value;
	public $label = false;
	public $parent;
	public $form;
	public $id;	
	public $errorMessage;
	public $defaultTemplateDir = 'forms';
	
	
	public function __construct (string $name) {
		
		$this->name = $name;
		$this->setDefaultRules();
		$this->initTags();
			
	}
	
	
	public function init () {
		$this->initTagThemes();
		$this->initTheme ('field');
		return $this;
	}
	
	
	public function __get ($name) {
		if (in_array ($name, ['name', 'type', 'weight', 'template'])) {
			return $this->$name;
		}
		else if ($name == 'rules') {
			return $this->rules();
		}
		else if (in_array ($name, ['livewireRules', 'lwRules'])) {
			return $this->livewireRules();
		}
	}
	
	
	protected function defaultRules() {
		return [];
	}
	
	
	public function formItemTag () {
		return $this->formItemTag;
	}
	
	public function labelContainerTag () {
		return $this->labelContainerTag;
	}
	
	public function labelTag () {
		return $this->labelTag;
	}
	
	public function fieldContainerTag () {
		return $this->fieldContainerTag;
	}
	
	public function errorMessageContainerTag () {
		return $this->errorMessageContainerTag;
	}
	
	public function errorMessageTag () {
		return $this->errorMessageTag;
	}
	
	public function errorIconContainerTag () {
		return $this->errorIconContainerTag;
	}
	
	public function errorIconTag () {
		return $this->errorIconTag;
	}
	
	public function requiredTag () {
		return $this->requiredTag;
	}
	
	public function colonTag () { 
		return $this->colonTag;
	}
	
	public function hideColon () {
		$this->colonTag->dontDisplayElement();
		return $this;
	}
	
	
	public function label (string $label) {
		$this->label = $label;
		return $this;
	}
	
	public function value ($value) {
		$this->value = $value;
		return $this;
	}
	

	
	protected function prerenderField () {
		$this->labelTag->addAttribute ('for', $this->id);
		$this->addAttribute ('id', $this->id);
	}
	
	
	protected function templateVariables () {

		return [
			
			'attributes' => $this->renderAttributes(),
			'value' => old ($this->name, $this->value),
			'type' => $this->type,
			'name' => $this->name,
			'id' => $this->id,
			'has_error' => $this->hasError(),
			'message' => $this->errorMessage,
			'label' => __($this->label), // Translate the label
			'help_text' => __($this->helpText), // Translate the help text
			'livewireModel' => (property_exists ($this, 'livewireModel')) ? $this->livewireModel : false,
			'prefix' => $this->prefix,
			'suffix' => $this->suffix,
			'form' => $this->form,
			
			'label_attributes' => $this->labelTag->renderAttributes(),
			'label_text_attributes' => $this->labelTextTag->renderAttributes(),
			'required_tag_attributes' => $this->requiredTag->renderAttributes(),
			'colon_tag_attributes' => $this->colonTag->renderAttributes(),
			'form_item_attributes' => $this->formItemTag->renderAttributes(),
			'label_container_attributes' => $this->labelContainerTag->renderAttributes(),
			'field_container_attributes' => $this->fieldContainerTag->renderAttributes(),
			'error_message_container_attributes' => $this->errorMessageContainerTag->renderAttributes(),
			'error_message_attributes' => $this->errorMessageTag->renderAttributes(),
			'error_icon_container_attributes' => $this->errorIconContainerTag->renderAttributes(),
			'error_icon_attributes' => $this->errorIconTag->renderAttributes(),

			'display_required_tag' => ($this->isRequired()) ? $this->requiredTag->display() : false,
			'display_colon_tag' => $this->colonTag->display(),
			'display_error_icon' => ($this->hasError() && $this->errorIconTag->display()) ? true : false,
			
		];
		
	}

	
}

