<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\FieldGroup;
use Coyote6\LaravelForms\Form\Radio;
use Coyote6\LaravelForms\Traits\Rules;
use Coyote6\LaravelForms\Traits\LivewireModel;
use Coyote6\LaravelForms\Traits\LivewireRules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class Radios extends FieldGroup {
	
	
	use Rules, LivewireModel;

		
	const NAME_EXTENSION = '-container';


	protected $type = 'radios';
	protected $template = 'radios';
	
	public $value;
	
	
	protected function defaultRules() {
		return ['nullable'];
	}
	
	
	public function rules () {
		$this->rules['in'] = Rule::in($this->optionValues());
		return $this->rules;
	}
	
	
#	public function addField (Field $field) {
#		$this->fields[$field->name . '--' . $field->value] = $field;
#		return $this;
#	}
	
	
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
	
	
	public function value ($value) {
		$this->value = $value;
		return $this;
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
			
			$radio->cache = $this->cache;
			$radio->theme = $this->theme;
			$radio->parent = $this;
			$radio->id = Form::uniqueId($radio->parent->id, $radio->name);
			
			$this->fields[$newName] = $radio;
		}
		return $this;
	}
	
	
	public function setOptions (array $options) {
		return $this->addOptions ($options);
	}
	
	
	protected function prerender () {

		$val = old ($this->name, $this->value);
		foreach ($this->sortFields() as $f) { 
			if ($f instanceof Radio && $f->name == $this->name && $val == $f->value) {
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
		
	
}