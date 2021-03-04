<?php
	

namespace Coyote6\LaravelForms\Traits;

	
trait LivewireRules {
	
	
	protected function getLivewireFieldRules ($field) {
		$name = $field->name;
		$fieldRules = $field->rules();
		$key = array_search ('confirmed', $fieldRules);
		if ($key !== false && isset ($this->fields[$name . '_confirmation']) && is_callable ([$this->fields[$name . '_confirmation'], 'getLivewireModel'])) {
			$fieldRules[$key] = 'same:' . $this->fields[$name . '_confirmation']->getLivewireModel();
		}
		return $fieldRules;
	}
	
	
	public function livewireRules (string $fieldName = null) {
		
		$rules = [];
		
		foreach ($this->flattenFields ($this->fields) as $field) {
#		foreach ($this->sortFields() as $name => $field) {

			if (is_callable ([$field, 'getLivewireModel']) && is_string ($field->getLivewireModel()) && $field->getLivewireModel() != '') {
				$r = $this->getLivewireFieldRules ($field);
				if (count ($r) > 0) {
					$rules[$field->getLivewireModel()] = $r;
				}
			}
#			else if ($field instanceof \Coyote6\LaravelForms\Form\FieldGroup) {
#				foreach ($field->lwRules() as $name => $r) {
#					if (count ($r) > 0) {
#						$rules[$name] = $r;
#					}
#				}
#			}

		}

		if (is_string ($fieldName) && $fieldName != '' && isset ($rules[$fieldName])) {
			return [$fieldName => $rules[$fieldName]];
		}

		return $rules;
		
	}
	
	
	public function lwRules (string $fieldName = null) {
		return $this->livewireRules($fieldName);
	}
	
	
}