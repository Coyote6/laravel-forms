<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\AddFields;
use Coyote6\LaravelForms\Traits\GroupedWithFormButtons;
use Coyote6\LaravelForms\Traits\LivewireRules;
use Coyote6\LaravelForms\Traits\Render;
use Coyote6\LaravelForms\Traits\Tags;
use Coyote6\LaravelForms\Traits\Theme;
use Coyote6\LaravelForms\Traits\Weighted;

use Illuminate\Database\Eloquent\Model;


class FieldGroup {


	use Attributes, AddFields, Weighted, GroupedWithFormButtons, Theme, Render, Tags;

			
	protected $type = 'field-group';
	protected $name;
	protected $template = 'field-group';

	public $label = false;
	public $parent;
	public $form;
	public $helpText;

	
	public function __construct (string $name) {
		
		$this->name = $name;
		
		$this->formItemTag = new FieldItem ($this, 'form-item');
		$this->initTags();
		$this->initTheme ('field');
		
		if ($this->defaultClasses) {
			$this->formItemTag->addClass ('field-group');
		}
				
	}
	
	public function __get ($name) {
		if (in_array ($name, ['name', 'type', 'weight', 'template'])) {
			return $this->$name;
		}
#		else if ($name == 'rules') {
#			return $this->rules();
#		}
#		else if (in_array ($name, ['livewireRules', 'lwRules'])) {
#			return $this->livewireRules();
#		}
	}

	
#	public function rules () {
#		$rules = [];
#		foreach ($this->sortFields() as $name => $field) {
#			if (count ($field->rules) > 0) {
#				$rules[$name] = $field->rules;
#			}
#		}
#		return $rules;
#	}
	
	public function isRequired () {
		return false;
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
	
	public function label (string $label) {
		$this->label = $label;
		return $this;
	}
	
	
	protected function sortFields () {
		$toSort = [];
		foreach ($this->fields as $name => $field) {
			$toSort[] = [
				'name' => $name,
				'weight' => $field->weight,
				'field' => $field
			];
		}
		$collection = collect ($toSort);
		return $collection->sortBy('weight', SORT_NUMERIC)->mapWithKeys(function ($item) {
			return [$item['name'] => $item['field']];
		});
	}
	
	
	protected function prerenderField () {
		$this->formItemTag->addAttribute ('id', $this->id . '--fieldgroup');
		$this->labelTag->addAttribute ('for', $this->id);
		$this->addAttribute ('id', $this->id);
	}
	
	
	protected function templateVariables () {

		return [
			
			'attributes' => $this->renderAttributes(),
			'fields' => $this->sortFields(),
			'type' => $this->type,
			'name' => $this->name,
			'id' => $this->id,
			'has_error' => $this->hasError(),
			'message' => $this->errorMessage,
			'label' => __($this->label), // Translate the label
			'help_text' => __($this->helpText), // Translate the help text
			
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
