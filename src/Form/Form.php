<?php
	

namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Form\Button;
use Coyote6\LaravelForms\Form\Checkbox;
use Coyote6\LaravelForms\Form\Email;
use Coyote6\LaravelForms\Form\FieldGroup;
use Coyote6\LaravelForms\Form\File;
use Coyote6\LaravelForms\Form\Hidden;
use Coyote6\LaravelForms\Form\Html;
use Coyote6\LaravelForms\Form\Image;
use Coyote6\LaravelForms\Form\Number;
use Coyote6\LaravelForms\Form\Radio;
use Coyote6\LaravelForms\Form\Radios;
use Coyote6\LaravelForms\Form\SubmitButton;
use Coyote6\LaravelForms\Form\Textarea;
use Coyote6\LaravelForms\Form\Text;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class Form {


	use Attributes;
		
	
	protected $model;
	protected $fields = [];
	protected $sortedFields = [];
	protected $method = 'POST';
	protected $methodOptions = ['POST', 'GET', 'PUT', 'DELETE'];
	protected $groupSubmitButtons = true;
	
	public $submitButton = true;
	public $action = '/';
	
	
	public function __construct ($model = null) {
		$this->classes = ['form'];
	}
	
	public function __toString() {
		$this->generateHtml();
	}
	
	
	public function method (string $method) {
		$method = strtoupper ($method);
		if (in_array ($method, $this->methodOptions)) {
			$this->method = $method;
		}
	}
	
	
	public function addField (Field $field) {
		if ($field instanceof Radio) {
			$fieldGroup = Radios::get($field->name);
			$fieldGroup->addField($field);
			$this->fields[$fieldGroup->name] = $fieldGroup;
		}
		else {
			$this->fields[$field->name] = $field;
		}
	}
	
	public function addFieldGroup (FieldGroup $fieldGroup) {
		$this->fields[$fieldGroup->name] = $fieldGroup;
	}
	
	public function button ($name) {
		$field = new Button ($name);
		$this->addField($field);
		return $field;
	}
	
	public function checkbox ($name) {
		$field = new Checkbox ($name);
		$this->addField($field);
		return $field;
	}
	
	public function email ($name) {
		$field = new Email ($name);
		$this->addField ($field);
		return $field;
	}
	
	public function fieldGroup ($name) {
		$field = new FieldGroup ($name);
		$this->addField($field);
		return $field;
	}
	
	public function file ($name) {
		$field = new File ($name);
		$this->addField($field);
		return $field;
	}
	
	public function files ($name) {
		$field = $this->file ($name);
		$field->addAttribute ('multiple', true);
		return $field;
	}
	
	public function hidden ($name) {
		$field = new Hidden ($name);
		$this->addField($field);
		return $field;
	}
	
	public function html ($name) {
		$field = new Html ($name);
		$this->addField($field);
		return $field;
	}
	
	public function image ($name) {
		$field = new Image ($name);
		$this->addField ($field);
		return $field;
	}
	
	public function images ($name) {
		$field = $this->image ($name);
		$field->addAttribute ('multiple', true);
		return $field;
	}
	
	public function number ($name) {
		$field = new Number ($name);
		$this->addField($field);
		return $field;
	}
	
	public function password ($name) {
		$field = new Password ($name);
		$this->addField ($field);
		return $field;
	}

	public function radios ($name) {
		$fieldGroup = new Radios ($name);
		$this->addFieldGroup ($fieldGroup);
		return $fieldGroup;
	}
	
	public function select ($name) {
		$field = new Select ($name);
		$this->addField($field);
		return $field;
	}
	
	public function string ($name) {
		return $this->text ($name);
	}
	
	public function submitButton ($name) {
		$field = new SubmitButton ($name);
		$this->addField($field);
		return $field;
	}
	
	public function text ($name) {
		$field = new Text ($name);
		$this->addField($field);
		return $field;
	}
	
	public function textarea ($name) {
		$field = new Textarea ($name);
		$this->addField($field);
		return $field;
	}
	
	public function textfield ($name) {
		return $this->text ($name);
	}
	
	
	public function getField (string $name) {
		if (isset ($this->fields[$name])) {
			return $this->fields[$name];
		}
	}
	
	
	public function ungroupSubmitButtons() {
		$this->groupSubmitButtons = false;
	}
	
	
	public function rules () {
		$rules = [];
		foreach ($this->sortFields() as $name => $field) {
			$rules[$name] = $field->rules;
		}
		return $rules;
	}
	
	
	public function validate () {
		return request()->validate($this->rules());
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
	
	
	public function generateHtml () {
		
		// See if there is a file field and/or a submit button.
		$hasFileField = false;
		$submitButtons = [];
		foreach ($this->fields as $f) {
			if ($f->type == 'file') {
				$hasFileField = true;
			}
			else if ($f->type == 'submit' || ($f->type == 'button' && $f->getAttr('type') == 'submit')) {
				$submitButtons[] = $f->name;
			}
		}
			
		// Add submit button if set to true and one isn't present.
		if ($this->submitButton && count ($submitButtons) == 0) {
			$b = $this->submitButton ('submit');
			$b->renderAsButton();
			$b->value = 'Submit';
			$submitButtons[] = 'submit';
		}

		$sortedFields = $this->sortFields();
		
		// Render all non-hidden fields.
		ob_start();
		foreach ($sortedFields as $f) { 
			if ($f instanceof Hidden || ($this->groupSubmitButtons && in_array ($f->name, $submitButtons)) || $f->isGroupedWithButtons()) {
				continue;
			}
			else {
				$f->render();
			}
		}
		$fields = ob_get_clean();
		
		// Render all hidden fields.
		ob_start();
		foreach ($sortedFields as $f) { 
			if ($f instanceof Hidden || (in_array ($f->name, $submitButtons) && $this->groupSubmitButtons) || $f->isGroupedWithButtons()) {
				$f->render();
			}
		}
		$hidden = ob_get_clean();
		
		// Add necessary attributes.
		$m = 'post';
		if ($this->method == 'GET') {
			$m = 'get';
		}
		$this->addAttribute ('method', $m);
		if (!is_string ($this->action)) {
			$this->action = '/';
		}
		$this->addAttribute ('action', $this->action);
		if ($hasFileField) {
			$this->addAttribute ('enctype', 'multipart/form-data');
		}
		
		// Export view.
		$vars = [
			'fields' => $fields,
			'attributes' => $this->renderAttributes(),
			'method' => $this->method,
			'hidden_fields' => $hidden
		];
		
		$template = 'forms.form';
		if (!view()->exists ($template)) {
      $template = 'laravel-forms::' . $template;
    }
		return view ($template, $vars);
	
	}
	
	
	public function render () {
		print $this->generateHtml();
	}
	
	
}