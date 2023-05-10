<?php
	

namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\File;
use Coyote6\LaravelForms\Form\Image;

	
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
		$isMulti = [];

		foreach ($this->flattenFields ($this->fields) as $field) {
#		foreach ($this->sortFields() as $name => $field) {

			if (is_callable ([$field, 'getLivewireModel']) && is_string ($field->getLivewireModel()) && $field->getLivewireModel() != '') {
				$r = $this->getLivewireFieldRules ($field);
				if ($field instanceof File) {
					$field->getAllUploads();			// Called to update the livewire properties for $propertyName . 'All' ($filesAll, $imagesAll, etc)
					if ($field->isMulti()) {
						$isMulti[$field->getLivewireModel()] = true;
					}
				}
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

		foreach ($rules as $name => $fieldRules) {
			if (isset ($isMulti[$name]) && $isMulti[$name]) {
				foreach ($fieldRules as $frn => $frv) {
					if (!in_array ($frn, ['nullable', 'required', 'sometimes'])) {
						$rules[$name . '.*'][$frn] = $frv;
						unset ($rules[$name][$frn]);
					}
				}
			}
		}
		
		if (is_string ($fieldName) && $fieldName != '') {
			$return = [];
			if (isset ($rules[$fieldName])) {
				$return[$fieldName] = $rules[$fieldName];
			}
			if (isset ($rules[$fieldName . '.*'])) {
				$return[$fieldName . '.*'] = $rules[$fieldName . '.*'];
			}
			return $return;
		}
		
		
		// Add a fake rule to prevent errors if the rules array is empty.
		if ($rules === []) {
			$this->setComponentProperty('noLivewireRules', time());
			$rules['noLivewireRules'] = 'nullable|sometimes';
		}
		

		return $rules;
		
	}
	
	
	public function lwRules (string $fieldName = null) {
		return $this->livewireRules($fieldName);
	}
	
	
}