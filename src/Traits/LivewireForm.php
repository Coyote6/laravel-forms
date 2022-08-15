<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait LivewireForm {

	
	protected $livewireComponent;
		
	//
	// Livewire Component
	//
	
	protected function isComponent ($component) {
		if (!class_exists('\Livewire\Livewire')) {
			trigger_error('The \Livewire\Livewire class was not found. Please make sure to install Livewire before using as a Livewire enabled form.');
		}
		if (class_exists ('\Livewire\Component') && $component instanceof \Livewire\Component) {
			return true;
		}
		return false;
	}
	
	
	public function getComponent () {
		return $this->livewireComponent;
	}
	
	
	public function setComponent ($value = null) {
		if ($this->isComponent ($value)){
			$this->livewireComponent = $value;
		}
		return $this->livewireComponent;
	}
	
	
	//
	// Livewire Form
	//
	
	public function livewireForm ($component) {
		if ($this->isComponent ($component)) {
			$this->livewireComponent = $component;
		}
		return $this;
	}
	
	
	public function lwForm ($component) {
		return $this->isLivewireForm();
	}
	
	
	//
	// Checks
	//
	
	public function isLivewireForm () {
		if (!is_null ($this->livewireComponent)) {
			return true;
		}
		return false;
	}
	
	
	public function isLwForm () {
		return $this->isLivewireForm();	
	}
	
	public function isLivewireRoute () {
		if ($this->isLwForm() && url()->current() == route ('livewire.message', $this->livewireComponent::getName())) {
			return true;
		}
		return false;
	}
	
	
	public function isLwRoute () {
		return $this->isLivewireRoute();
	}
	
	
	//
	// Component Properties
	//
	
	public function getComponentProperty (string $propertyName) {
		if (property_exists ($this->getComponent(), $propertyName) && !is_null ($this->getComponent()->$propertyName)) {
			return $this->getComponent()->$propertyName;
		}
	}
	
	public function setComponentProperty (string $propertyName, $value = null) {
		$this->getComponent()->$propertyName = $value;
		return $value;
	}
	
	
	//
	// Helper Methods
	//
	
	public function wireSubmit (string $methodName) {
		$this->addAttribute('wire:submit.prevent', $methodName);
		return $this;
	}

	
}