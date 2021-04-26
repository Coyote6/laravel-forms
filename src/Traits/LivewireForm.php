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
	
	
	public function livewireForm ($component) {
		if ($this->isComponent ($component)) {
			$this->livewireComponent = $component;
		}
		return $this;
	}
	
	
	public function lwForm ($component) {
		return $this->isLivewireForm();
	}
	
	
	public function isLivewireForm () {
		if (!is_null ($this->livewireComponent)) {
			return true;
		}
		return false;
	}
	
	
	public function isLwForm () {
		return $this->isLivewireForm();	
	}
	
}