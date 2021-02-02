<?php
	

namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\AddFields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class Form {


	use Attributes, AddFields;
		
	
	protected $model;
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
		return $this->generateHtml();
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
		return view ($template, $vars)->render();
	
	}
	
	
	public function render () {
		print $this->generateHtml();
	}
	
	
}