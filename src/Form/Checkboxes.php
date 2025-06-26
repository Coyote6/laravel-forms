<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\FieldGroup;
use Coyote6\LaravelForms\Form\Radio;
use Coyote6\LaravelForms\Traits\Rules;
use Coyote6\LaravelForms\Traits\LivewireModel;
use Coyote6\LaravelForms\Traits\LivewireRules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class Checkboxes extends FieldGroup {
	
	
	use Rules, LivewireModel;

		
	const NAME_EXTENSION = '-container';


	protected $type = 'checkboxes';
	protected $template = 'checkboxes';
	
	public $value;
	
	
	protected function defaultRules() {
		return ['nullable'];
	}
	
	
	public function rules () {
		
		$this->rules['in'] = Rule::in($this->optionValues());
		$this->rules['array'] = 'array';

		if (isset ($this->rules['required'])) {
			$this->rules['min'] = 1;
		}	
		
		return $this->rules;
	}
	
	
#	public function addField (Field $field) {
#		$this->fields[$field->name . '--' . $field->value] = $field;
#		return $this;
#	}
	
	
	public static function get ($name) {
		static $allCheckboxes;
		if (is_null ($allCheckboxes)) {
			$allCheckboxes = [];
		}
		if (!isset ($allCheckboxes[$name . static::NAME_EXTENSION])) {
			$allCheckboxes[$name . static::NAME_EXTENSION] = new Radios($name . static::NAME_EXTENSION);
		}
		return $allCheckboxes[$name . static::NAME_EXTENSION];
	}
	
	
	public function value ($value) {
		$this->value = $value;
		return $this;
	}
	
	
	public function optionValues () {
		$options = [];
		foreach ($this->sortFields() as $f) {
			if ($f instanceof Checkbox) {
				$options[] = $f->value;	
			}	
		}
		return $options;
	}
	
	
	public function addOptions (array $options) {
		foreach ($options as $value => $label) {	
			
			$newName = $this->name . '--' . $value;
			$checkbox = new Checkbox ($this->name . '[]');

			$checkbox->label = $label;
			$checkbox->value = $value;
			
			$checkbox->cache = $this->cache;
			$checkbox->theme = $this->theme;
			$checkbox->parent = $this;
			$checkbox->id = Form::uniqueId($checkbox->parent->id, $checkbox->name);
			
			$this->fields[$newName] = $checkbox;
			$this->fields[$newName]->hideColon();
		}
		return $this;
	}
	
	
	public function setOptions (array $options) {
		return $this->addOptions ($options);
	}
	
	
	protected function prerender () {

		$val = old ($this->name, $this->value);
		foreach ($this->sortFields() as $f) { 
			if ($f instanceof Checkbox && $f->name == $this->name && $val == $f->value) {
				$f->addAttribute('checked');
			}
			if (is_string ($this->livewireModel) && $this->livewireModel != '') {
				if ($this->livewireLoad == 'lazy') {
					$f->lwLazy($this->livewireModel);
				}
				else {
					$f->lw($this->livewireModel);
				}
			}
		}
				
	}
	
	
	protected function templateVariables () {
	
		$vars = parent::templateVariables();
			
		// HACK JOB
		//
		// Livewire 2's Component method $this->validateOnly() is changing validation rules for arrays.
		//
		// This is just a visual error check. Bad values can still be passed to the array by changing the
		// input's value in the inspector.  Out of time to fix properly as it doesn't hurt the project this
		// is being used in as those checkbox values are not being saved to the database, but just adjusting
		// the user's displays and bad values are ignored.
		//
		// This is in here in case someone else uses this library in their project.  This library is slated to
		// be updated to Livewire 3 (or 4) w/ Flux Template options in the future, but all form structures must be
		// reworked to accommodate the changes.
		//
		if (!$vars['has_error']) {
			if (property_exists ($this, 'livewireModel')) {
				$prop = $this->form->getComponentProperty($this->livewireModel);

				$fieldRules = $this->rules();
				$rules = [];
				if (isset ($fieldRules['in'])) {
					$rules[$this->livewireModel . '.*'] = $fieldRules['in'];
					unset ($fieldRules['in']);
				}
				$rules[$this->livewireModel] = $fieldRules;
				$validator = Validator::make ([$this->livewireModel => $prop], $rules);
				if ($validator->fails()) {
					$vars['has_error'] = true;
					$vars['message'] = 'A value entered into a checkbox is invalid.';
				}

			}
		}
		
		return $vars;
		
	}
		
	
}