<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait LivewireForm {

	
	protected $livewireComponent;
		
	
	protected function isComponent ($component) {
		if (class_exists ('\Livewire\Component') && $component instanceof \Livewire\Component) {
			return true;
		}
		return false;
	}
	
	
	public function isLivewireForm ($component) {
		if ($this->isComponent ($component)) {
			$this->livewireComponent = $component;
		}
	}
	
	
	public function isLwForm ($component) {
		$this->isLivewireForm();
	}
	
}