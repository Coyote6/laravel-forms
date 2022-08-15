<?php
	

namespace Coyote6\LaravelForms\Livewire;


use Coyote6\LaravelForms\Contracts\HasForm;

use function Livewire\str;
use Livewire\Component as LivewireComponent;
use Livewire\ObjectPrybar;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


abstract class Component extends LivewireComponent {
	
	
	public function template () {

		if (property_exists ($this, 'template') && view()->exists ($this->template)) {
			return $this->template;
		}

		$template = 'livewire.forms.form';
		if (!view()->exists ($template)) {
			$template = 'forms::' . $template;
		}
		return $template;
		
	}
	
	public function formTitle () {
		if (property_exists ($this, 'formTitle')) {
			return $this->formTitle;
		}
		return false;
	}
	
	public function formTitleTag () {
		if (property_exists ($this, 'formTitleTag') && in_array ($this->formTitleTag, ['div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'label'])) {
			return $this->formTitleTag;
		}
		return 'h2';
	}

	
	public function rules () {
		return $this->form()->lwRules();
	}
	
	
	public function updated ($field) {
		$this->validateOnly ($field);
	}
	
	
	public function prepareForValidation ($data) {
		return $this->form()->prepareForValidation ($data);
	}
	
	
	public function validate ($rules = null, $messages = [], $attributes = []) {
    	$validatedData = parent::validate ($rules, $messages, $attributes);
		$validatedData = $this->form()->postValidation ($validatedData);
        return $validatedData;
        
	}
	
	
	public function validateOnly ($field, $rules = null, $messages = [], $attributes = []) {
    	$validatedData = parent::validateOnly ($field, $rules, $messages, $attributes);
		$validatedData = $this->form()->postValidation ($validatedData);
        return $validatedData;
    }
	
	
	public function render () {
		return view ($this->template(), $this->renderVars());
	}
	
	
	//
	// @return array
	//
	protected function renderVars () {
		$vars = [
			'form' => $this->form(),
			'formTitle' => $this->formTitle(),
			'formTitleTag' => $this->formTitleTag()
		];
		foreach ($this->customRenderVars() as $name => $var) {
			$vars[$name] = $var;
		}
		return $vars;
	}
	
	
	//
	// @return array
	//
	protected function customRenderVars () {
		return [];
	}
	
	
	public function form ($regenerate = false) {
		
		if (property_exists ($this, 'formId') && is_string ($this->formId) && $this->formId != '') {
			static $forms;
			if (is_null ($forms) || !isset ($forms[$this->formId]) || $regenerate) {
				$forms[$this->formId] = $this->generateForm();
			}
			return $forms[$this->formId];
		}
		
		static $form;
		if (is_null ($form) || $regenerate) {
			$form = $this->generateForm();
		}
		return $form;
	}
	
	/**
     * Returns a Coyote6\LaravelForms\Form\Form instance.
     *
     * @return Form
     */
    abstract protected function generateForm ();
	
}