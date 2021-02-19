<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\FieldGroup;
use Coyote6\LaravelForms\Form\Radio;
use Coyote6\LaravelForms\Traits\Rules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class Radios extends FieldGroup {
	
	use Rules;

		
	const NAME_EXTENSION = '-container';


	protected $type = 'radios';
	
	
	public function __get ($name) {
		
		//
		// We can't put the in: validation into the default rules
		// as we do not know the option values when the field is
		// first added, so until we are validating the rules to get
		// the option values.
		//
		if ($name == 'rules' && !isset ($this->rules['in'])) {
			$this->rules['in'] = Rule::in($this->optionValues());
			return $this->rules;
		}
		
		return parent::__get ($name);
	}
	
	
	protected function defaultRules() {
		return ['nullable'];
	}
	
	
	public function addField (Field $field) {
		$this->fields[$field->name . '--' . $field->value] = $field;
	}
	
	
	public static function get ($name) {
		static $allRadios;
		if (is_null ($allRadios)) {
			$allRadios = [];
		}
		if (!isset ($allRadios[$name . static::NAME_EXTENSION])) {
			$allRadios[$name . static::NAME_EXTENSION] = new Radios($name . static::NAME_EXTENSION);
		}
		return $allRadios[$name . static::NAME_EXTENSION];
	}
	
	
	public function optionValues () {
		$options = [];
		foreach ($this->sortFields() as $f) {
			if ($f instanceof Radio) {
				$options[] = $f->value;
			}	
		}
		return $options;
	}
	
	
	public function addOptions (array $options) {
		foreach ($options as $value => $label) {
			$newName = $this->name . '--' . $value;
			$radio = new Radio ($this->name);
			$radio->label = $label;
			$radio->value = $value;
			$this->fields[$newName] = $radio;
		}
	}
	
	public function setOptions (array $options) {
		$this->addOptions ($options);
	}
	
	
	public function generateHtml () {
		
		$val = old ($this->name, $this->value);
		foreach ($this->sortFields() as $f) { 
			if ($f instanceof Radio && $f->name == $this->name && $val == $f->value) {
				$f->addAttribute('checked');
			}
		}
		
		return parent::generateHtml();
		
	}
		
	
}