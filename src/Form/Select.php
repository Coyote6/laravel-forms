<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;
use Coyote6\LaravelForms\Form\Option;
use Coyote6\LaravelForms\Traits\Options;
use Illuminate\Validation\Rule;


class Select extends Field {
	
	protected $type = 'select';
	protected $template = 'select';


	use Options;	
	
	
	protected function defaultRules() {
		return ['nullable'];
	}
	
	
	public function rules () {
		if (!$this->hasAttribute('multiple')) {
			$this->rules['in'] = Rule::in($this->optionValues());
		}
		else {
			$this->rules['array'] = 'array';
		}
		return $this->rules;
	}
	
	
	public function multipleSelect (string $table, string $column = 'id') {
		$this->addAttribute ('multiple');
		$this->addRule ('exists:' . $table . ',' . $column);
		return $this;
	}
	
	public function multiple (string $table, string $column = 'id') {
		return $this->multipleSelect ($table, $column);
	}
	
	public function multi (string $table, string $column = 'id') {
		return $this->multipleSelect ($table, $column);
	}
	
	public function multiSelect (string $table, string $column = 'id') {
		return $this->multipleSelect ($table, $column);
	}

		
	public function renderAttributes () {
		$this->addAttribute ('name', $this->name);
		return parent::renderAttributes();
	}
	
	
	protected function prerender () {
		
		$val = old ($this->name, $this->value);

		// Must shutoff for 'selected' for Livewire
		//
		// @see https://github.com/livewire/livewire/issues/998
		// @see https://github.com/livewire/livewire/issues/860
		//
		$livewireReturnUrl = route('livewire.message','');
		$currentUrl = substr (url()->current(), 0, strlen ($livewireReturnUrl));
		$isLivewireReturnUrl = ($livewireReturnUrl == $currentUrl);
	
		$hasDefault = false;
		foreach ($this->options as $o) {
			if (!$this->hasAttribute('multiple')) {
				if ($o->value == $val) {
					$o->addAttribute('selected');
				}
			}
			
			else if (is_array ($val) && !$isLivewireReturnUrl) {
				
				foreach ($val as $v) {
					if ($o->value == $v) {
						$o->addAttribute('selected');
					}
				}
			}
			if ($o->value == '') {
				$hasDefault = true;
			}
		}
		
		if (!$hasDefault && !$this->hasAttribute('multiple')) {
			$default = new Option();
			$default->value = '';
			$default->label = '-- Please Select --';
			array_unshift($this->options, $default);
		}
		
		$this->labelTag->addAttribute ('for', $this->id);
		$this->addAttribute ('id', $this->id);
	
	}
	
	
	public function templateVariables () {
		$vars = parent::templateVariables();
		$vars += ['options' => $this->options()];
		return $vars;
	}
		
}


