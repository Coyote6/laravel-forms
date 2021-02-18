<?php
	

namespace Coyote6\LaravelForms\Traits;

	
trait LivewireRules {
	
	
	public function livewireRules () {
		
		$rules = [];

		foreach ($this->sortFields() as $name => $field) {
			if (is_string ($field->getLivewireModel()) && $field->getLivewireModel() != '') {
				$fieldRules = $field->rules;
				$key = array_search ('confirmed', $fieldRules);
				if ($key !== false && isset ($this->fields[$name . '_confirmation'])) {
					$fieldRules[$key] = 'same:' . $this->fields[$name . '_confirmation']->getLivewireModel();
				}
				$rules[$field->getLivewireModel()] = $fieldRules;
			}
		}

		return $rules;
		
	}
	
	
	public function lwRules () {
		return $this->livewireRules();
	}
	
	
}