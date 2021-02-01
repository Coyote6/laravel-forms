<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\GroupedWithFormButtons;
use Coyote6\LaravelForms\Traits\Weighted;

use Illuminate\Database\Eloquent\Model;


class FieldGroup {


	use Attributes, Weighted, GroupedWithFormButtons;
		
			
	protected $type = 'field-group';
	protected $name;
	protected $template = 'field-group';
	protected $fields = [];
	
	public $label = false;
	
	public function __construct (string $name) {
		$this->name = $name;
	}
	
	public function __get ($name) {
		if (in_array ($name, ['name', 'type', 'weight', 'template'])) {
			return $this->$name;
		}
		else if ($name == 'rules') {
			$rules = [];
			foreach ($this->sortFields() as $name => $field) {
				$rules[$name] = $field->rules;
			}
			return $rules;
		}
	}
	
	
	public function __toString() {
		$this->generateHtml();
	}
	
	
	public function addField (Field $field) {
		$this->fields[$field->name] = $field;
	}
	
	
	public function fields () {
		return $this->fields;
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
		ob_start();
		foreach ($this->sortFields() as $f) { 
			$f->render();
		}
		$vars = [
			'content' => ob_get_clean(),
			'attributes' => $this->renderAttributes(),
			'label' => $this->label,
			'id' => $this->name,
			'name' => $this->name,
			'type' => $this->type
		];
		
		$template = 'forms.field-group';
		if (!view()->exists ($template)) {
      $template = 'laravel-forms::' . $template;
    }
		return view ($template, $vars);
	}
	
	
	public function render () {
		print $this->generateHtml();
	}
	
	
}
