<?php
	

namespace Coyote6\LaravelForms\Traits;

	
trait LivewireRules {
	
	
	public function livewireRules () {
		$rules = [];
		foreach ($this->sortFields() as $name => $field) {
			if (is_string ($field->getLivewireModel()) && $field->getLivewireModel() != '') {
				$rules[$field->getLivewireModel()] = $field->rules;
			}
		}
		return $rules;
	}
	
	
	public function lwRules () {
		return $this->livewireRules();
	}
	
	
}