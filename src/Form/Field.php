<?php

namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\GroupedWithFormButtons;
use Coyote6\LaravelForms\Traits\LivewireModel;
use Coyote6\LaravelForms\Traits\Render;
use Coyote6\LaravelForms\Traits\Rules;
use Coyote6\LaravelForms\Traits\Tags;
use Coyote6\LaravelForms\Traits\Theme;
use Coyote6\LaravelForms\Traits\Weighted;


abstract class Field {


	use Attributes, Weighted, Rules, GroupedWithFormButtons, LivewireModel, Theme, Render, Tags;
	
		
	protected $type;
	protected $name;
	protected $template;	
	
	public $value;
	public $label = false;
	public $parent;
	public $form;
	public $errorMessage;
		
	
	public function __construct (string $name) {
		
		$this->name = $name;
		$this->setDefaultRules();
		
		$this->initTags();
		$this->initTheme ('field');
		
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
	
	
	protected function prerenderField () {
		$this->labelTag->addAttribute ('for', $this->name);
		$this->addAttribute ('id', $this->name);
	}
	
	
	protected function templateVariables () {

		return [
			
			'attributes' => $this->renderAttributes(),
			'value' => old ($this->name, $this->value),
			'type' => $this->type,
			'name' => $this->name,
			'has_error' => $this->hasError(),
			'message' => $this->errorMessage,
			'label' => __($this->label), // Translate the label
			
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

			'display_form_item' => $this->formItemTag->display(),
			'display_label_container' => $this->labelContainerTag->display(),
			'display_label' => $this->labelTag->display(),
			'display_label_text' => $this->labelTextTag->display(),
			'display_required_tag' => ($this->isRequired()) ? $this->requiredTag->display() : false,
			'display_colon_tag' => $this->colonTag->display(),
			'display_field_container' => $this->fieldContainerTag->display(),
			'display_error_message_container' => $this->errorMessageContainerTag->display(),
			'display_error_icon_container' => $this->errorIconContainerTag->display(),
			'display_error_icon' => ($this->hasError() && $this->errorIconTag->display()) ? true : false,
			
		];
		
	}

	
}

