<?php
	

namespace Coyote6\LaravelForms\Livewire;


use Coyote6\LaravelForms\Contracts\HasForm;
use Livewire\Component as LivewireComponent;


abstract class Component extends LivewireComponent {
	
	public function template () {
		$template = 'livewire.forms.form';
		if (!view()->exists ($template)) {
			$template = 'laravel-forms::' . $template;
		}
		return $template;
	}
	
	public function rules () {
		return $this->form()->lwRules();
	}
	
	public function updated ($field) {
		$this->validateOnly ($field);
	}
	
	public function render () {
		$vars = [
			'form' => $this->form()
		];
		return view ($this->template(), $vars);
	}
	
	protected function form () {
		static $form;
		if (is_null ($form)) {
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