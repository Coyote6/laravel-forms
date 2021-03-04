<?php
	

namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\AddFields;
use Coyote6\LaravelForms\Traits\LivewireRules;
use Coyote6\LaravelForms\Traits\LivewireForm;
use Coyote6\LaravelForms\Traits\Render;
use Coyote6\LaravelForms\Traits\Theme;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\ViewErrorBag;

class Form {


	use Attributes, AddFields, LivewireForm, LivewireRules, Theme, Render;
		
	
	protected $model;
	protected $sortedFields = [];
	protected $method = 'POST';
	protected $methodOptions = ['POST', 'GET', 'PUT', 'DELETE'];
	protected $groupSubmitButtons = true;
	protected $template = 'form';
	
	
	public $submitButton = true;
	public $action = '/';
	
	
	public function __construct ($object = null) {
		
		if (is_object ($object)) {
			if ($this->isComponent ($object)) {
				$this->isLivewireForm ($object);
			}
		}
		
		$this->initTheme('form');
	}

	
	
	public function method (string $method) {
		$method = strtoupper ($method);
		if (in_array ($method, $this->methodOptions)) {
			$this->method = $method;
		}
	}
	
	
	public function ungroupSubmitButtons() {
		$this->groupSubmitButtons = false;
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

	
	protected function setError ($field) {
		$field->formItemTag()->setError();
		$field->labelContainerTag()->setError();
		$field->labelTag()->setError();
		$field->fieldContainerTag()->setError();
		$field->setError();
		$field->errorMessageContainerTag()->setError();
		$field->errorMessageTag()->setError();
	}
	
	
	
	public function templateVariables () {
	
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
			
			if (is_callable ($f, 'isRequired') && $f->isRequired() && is_callable ($f, 'rules')) {
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
				
		return [
			'fields' => $fields,
			'attributes' => $this->renderAttributes(),
			'method' => $this->method,
			'hidden_fields' => $hidden,
			'has_confirm_field' => $hasConfirmField,
		];
		
	}
	
	
}