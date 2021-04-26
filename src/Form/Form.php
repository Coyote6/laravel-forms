<?php
	

namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\FieldItem;
use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\AddFields;
use Coyote6\LaravelForms\Traits\LivewireRules;
use Coyote6\LaravelForms\Traits\LivewireForm;
use Coyote6\LaravelForms\Traits\Render;
use Coyote6\LaravelForms\Traits\Theme;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class Form {


	use Attributes, AddFields, LivewireForm, LivewireRules, Theme, Render;
		
	
	protected $model;
	protected $sortedFields = [];
	protected $method = 'POST';
	protected $methodOptions = ['POST', 'GET', 'PUT', 'DELETE'];
	protected $groupSubmitButtons = true;
	protected $template = 'form';
	
	protected $errorMessageContainerTag;
	protected $errorMessageTag;
	
	public $submitButton = true;
	public $action = '#';
	
	public $renderedFields = [];
	public $id;
	
	
	public function __construct ($options = null) {

		$this->setDefaultId();	
		
		if (is_object ($options)) {
			
			// Livewire
			if ($this->isComponent ($options)) {
				$this->livewireForm ($options);
			}
			
			// ToDo: Model
			
		}
		else if (is_array ($options)) {
			
			// Manually set the form id.
			if (isset ($options['id'])) {
				$this->id = $options['id'];
			}
			
			// Livewire
			if (isset ($options['livewire']) && is_object ($options['livewire']) && $this->isComponent ($options['livewire'])) {
				$this->livewireForm ($options['livewire']);
			}
			else if (isset ($options['lw']) && is_object ($options['lw']) && $this->isComponent ($options['lw'])) {
				$this->livewireForm ($options['lw']);
			}
			
			// Cache
			if (isset ($options['cache']) && is_bool ($options['cache'])) {
				$this->cache = $options['cache'];
			}
			
			// Theme
			if (isset ($options['theme']) && is_string ($options['theme']) && $options['theme'] != '') {
				$this->theme = $options['theme'];
			}
			
		}
		
		$this->errorMessageContainerTag = new FieldItem ($this, 'form--error-message-container');
		$this->errorMessageTag = new FieldItem ($this, 'form--error-message');
		$this->initTheme('form');
		
		
	}
	
	
	public function setDefaultId () {
		
		$class = class_basename (__CLASS__);
		$function = null;
		
		$backtrace = debug_backtrace();
		if (isset ($backtrace[2])) {
			if (isset ($backtrace[2]['class'])) {
				$class = class_basename ($backtrace[2]['class']);
			}
			if (isset ($backtrace[2]['function'])) {
				$function = $backtrace[2]['function'];
			}
		}
		
		$id = $this->formatIdStr ($class);
		if (is_string ($function) && $function != '') {
			$id .= '--' . $this->formatIdStr ($function);
		}
		
		$this->id = $id;
		
		return $this;
		
	}
	
	
	public function formatIdStr (string $str) {
		preg_match_all ('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
		$ret = $matches[0];
		foreach ($ret as &$match) {
		    $match = $match == strtoupper ($match) ? strtolower($match) : lcfirst($match);
		}
		return implode('-', $ret);
	}

	
	public static function uniqueId (string $parentId, string $name) {
		
		static $ids;

		$id = $parentId . '--' . $name;
		$count = 1;
		while (isset ($ids[$id])) {
			$id = $parentId . '--' . $name . '--' . $count;
			$count++; 
		}

		$ids[$id] = $id;
		return $id;
		
	}
	

	public function action (string $action) {
		$this->action = $action;
		return $this;
	}
	
		
	public function method (string $method) {
		$method = strtoupper ($method);
		if (in_array ($method, $this->methodOptions)) {
			$this->method = $method;
		}
		return $this;
	}
	
	
	public function ungroupSubmitButtons() {
		$this->groupSubmitButtons = false;
		return $this;
	}
	
	
	public function rules () {
		$rules = [];

		foreach ($this->flattenFields ($this->fields) as $field) {
			if (is_callable ([$field, 'rules'])) {
				$name = $field->name;
				$r = $field->rules();
				if (is_array ($r) && count ($r) > 0) {
					$rules[$name] = $r;
				}
			}
		}
		return $rules;
	}
	
	
	public function validate () {
		return request()->validate ($this->rules());
	}

	
	public function errors() {
		static $errors;
		if (is_null ($errors)) {
			if (is_null ($this->livewireComponent)) {
				$errors = session()->get('errors', app(ViewErrorBag::class));
			}
			else {
				$errors = $this->livewireComponent->getErrorBag();
			}
		}
		return $errors;
	}
	
	
	public function hasError ($fieldName) {
		return $this->errors()->has($fieldName);
	}
	
	
	protected function setError ($field) {
		$field->formItemTag()->setError();
		$field->labelContainerTag()->setError();
		$field->labelTag()->setError();
		$field->fieldContainerTag()->setError();
		$field->setError();
		$field->errorMessageContainerTag()->setError();
		$field->errorMessageTag()->setError();
	}
	
	
	
#	public function throwFieldError (string $fieldName, string $errorMessage) {
#		if ($this->getField ($fieldName)) {
		//	throw ValidationException::withMessages([$fieldName => $errorMessage]);
#		}
#	}
	
	
	public function addFieldError (string $fieldName, string $errorMessage) {
		if ($this->getField ($fieldName)) {
			if (is_null ($this->livewireComponent)) {
				$app = app();
				$errors = $app[MessageBag::class];
			}
			else {
				$errors = $this->livewireComponent->getErrorBag();
			}
			$errors->add ($fieldName, $errorMessage);
			#$this->setError ($this->getField ($fieldName));
		}
		return $this;
	}
	
	
	protected function flattenFields ($fields) {
		$flatten = [];
		foreach ($fields as $f) {
			if (is_callable ([$f, 'fields'])) {
				$flatten[] = $f;
				foreach ($this->flattenFields ($f->fields()) as $child) {
					$flatten[] = $child;
				}
			}
			else {
				$flatten[] = $f;
			}
		}
		return $flatten;
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
	
	
	public function renderedField (string $field) {
		$this->renderedFields[$field] = $field;
	}
	
	
	public function templateVariables () {
		
		// Add the id to the form.
		$this->addAttribute('id', $this->id);
	
		// See if there is a file field and/or a submit button,
		// and add the error classes for any with errors.
		//
		$hasFileField = false;
		$submitButtons = [];
		$hasConfirmField = false;

		$flattenedFields = $this->flattenFields ($this->fields);
		foreach ($flattenedFields as $f) {
			
			//
			// Check if a confirm field exists.
			//
			if (is_callable ([$f, 'hasConfirmField']) && $f->hasConfirmField()) {
				$hasConfirmField = true;
			}
			
			
			//
			// Check for errors and set the classes if any are found.
			//
			$errorName = (is_callable ([$f, 'getLw'])) ? $f->getLw() : $f->name;

			if ($this->hasError ($errorName)) {

				$this->setError ($f);
				$f->errorMessage = $this->errors()->first($errorName);

				// If it exists, error the confirmed field as well.
				if (is_callable ([$f, 'rules']) && is_callable([$f, 'hasConfirmField']) && $f->hasConfirmField()) {
					
					if (key_exists ('confirmed', $f->rules())) {
						$confirmFieldName = $f->name . '_confirmation';
						if (isset ($this->fields[$confirmFieldName])) {
							$this->setError ($this->fields[$confirmFieldName]);
						}
					}
	
					// If it exists, error the field that should have the same value as well.
					if (key_exists ('same', $f->rules())) {
						$sameField = $f->rules['same'];
						$explode = explode (':', $sameField);
						if (isset ($explode[1]) && isset ($this->fields[$explode[1]])) {
							$this->setError ($this->fields[$explode[1]]);
						}
					}
				}
			}
			
			//
			// Check for confirmation fields and require them if the primary field
			// is required.
			//
			if (is_callable ([$f, 'isRequired']) && $f->isRequired() && is_callable ([$f, 'rules'])) {

				if (key_exists ('confirmed', $f->rules())) {
					$confirmFieldName = $f->name . '_confirmation';
					if (isset ($this->fields[$confirmFieldName])) {
						$this->fields[$confirmFieldName]->required();
					}
				}
	
				// If it exists, error the field that should have the same value as well.
				if (key_exists ('same', $f->rules())) {
					$sameField = $f->rules['same'];
					$explode = explode (':', $sameField);
					if (isset ($explode[1]) && isset ($this->fields[$explode[1]])) {
						$this->fields[$explode[1]]->required();
					}
				}
			}
			
			if ($f->type == 'file') {
				$hasFileField = true;
			}
			else if ($f->type == 'submit' || ($f->type == 'button' && $f->getAttr('type') == 'submit')) {
				$submitButtons[] = $f->name;
			}

		}
		
		if ($this->hasError ('form')) {
			$this->errorMessageContainerTag->setError();
			$this->errorMessageTag->setError();
		}
		
		// Add submit button if set to true and one isn't present.
		if ($this->submitButton && count ($submitButtons) == 0) {
			$b = $this->submitButton ('submit');
			$b->value = 'Submit';
			$submitButtons[] = 'submit';
		}

		$sortedFields = $this->sortFields();
		
		// Render all non-hidden fields.
		$fields = [];
		foreach ($sortedFields as $key => $f) { 
			if ($f instanceof Hidden || ($this->groupSubmitButtons && in_array ($f->name, $submitButtons)) || $f->isGroupedWithButtons()) {
				continue;
			}
			else {
				$fields[$key] = $f;
			}
		}
		
		// Render all hidden fields.
		$hidden = [];
		foreach ($sortedFields as $key => $f) { 
			if ($f instanceof Hidden || (in_array ($f->name, $submitButtons) && $this->groupSubmitButtons) || $f->isGroupedWithButtons()) {
				$hidden[$key] = $f;
			}
		}
		
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
		
		$display_error_container_tag = config ('laravel-forms.display--form-error-message-container-tag', true);
		if (!is_bool ($display_error_container_tag)) {
			$display_error_container_tag = true;
		}
		
		return [
			'id' => $this->id,
			'fields' => $fields,
			'attributes' => $this->renderAttributes(),
			'method' => $this->method,
			'hidden_fields' => $hidden,
			'has_confirm_field' => $hasConfirmField,
			'error_message_container_attributes' => $this->errorMessageContainerTag->renderAttributes(),
			'error_message_attributes' => $this->errorMessageTag->renderAttributes(),
			'is_livewire_form' => $this->isLwForm()
		];
		
	}
	
	
}