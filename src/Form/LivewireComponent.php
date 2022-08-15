<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Field;


class LivewireComponent extends Field {
	
	
	protected $type = 'livewire';
	protected $template = 'livewire';
	
	protected function defaultRules() {
		return [];
	}
	
	
	protected function prerender () {}
	
}


