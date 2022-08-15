<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\Field;


trait LivewireModel {
	
	
	protected $livewireModel = '';
	protected $livewireLoad = 'normal';
	protected $livewireDebounce = 750;
	
	
	//
	// LW
	//
	
	public function livewireModel (string $name = null) {
		if (is_null ($name) || $name == '') {
			$name = $this->name;
		}
		$this->livewireModel = $name;
		$this->livewireLoad = 'normal';
		if ($this instanceof Field) {
			$this->addAttribute ('wire:model', $name);
		}
		return $this;
	}
	
	public function lwModel (string $name = null) {
		return $this->livewireModel ($name);
	}
	
	public function lw (string $name = null) {
		return $this->livewireModel ($name);
	}
	
	
	//
	// Lw Lazy
	//
	
	public function livewireModelLazy (string $name = null) {
		if (is_null ($name) || $name == '') {
			$name = $this->name;
		}
		$this->livewireModel = $name;
		$this->livewireLoad = 'lazy';
		if ($this instanceof Field) {
			$this->addAttribute ('wire:model.lazy', $name);
		}
		return $this;
	}
	
	public function lwModelLazy (string $name = null) {
		return $this->livewireModelLazy ($name);
	}
	
	public function lwLazy (string $name = null) {
		return $this->livewireModelLazy ($name);
	}
	
	
	//
	// Lw Debounce
	//
	
	public function livewireModelDebounce (string $name = null, int $milliseconds = 750) {
		if (is_null ($name) || $name == '') {
			$name = $this->name;
		}
		$this->livewireModel = $name;
		$this->livewireLoad = 'debounce';
		$this->livewireDebounce = $milliseconds;
		if ($this instanceof Field) {
			$this->addAttribute ('wire:model.debounce.' . $milliseconds . 'ms', $name);
		}
		return $this;
	}
	
	public function lwModelDebounce (string $name = null, int $milliseconds = 750) {
		return $this->livewireModelDebounce ($name, $milliseconds);
	}
	
	public function lwDebounce (string $name = null, int $milliseconds = 750) {
		return $this->livewireModelDebounce ($name, $milliseconds);
	}
	
	
	//
	// Retrieval
	//
	
	public function getLivewireModel () {
		return $this->livewireModel;
	}
	
	public function getLwModel () {
		return $this->getLivewireModel();
	}
	
	public function getLw () {
		return $this->getLivewireModel();
	}
		
	
	//
	// Check
	//
	
	public function isLivewire () {
		if (is_string ($this->livewireModel) && $this->livewireModel != '') {
			return true;
		}
		return false;
	}
	
	
	public function isLw () {
		return $this->isLivewire();
	}
	
	
	//
	// Component & Component Properties
	//
	
	public function getComponent () {
		return $this->form->getComponent ();
	}
	
	public function setComponent ($value = null) {
		return $this->form->setComponent ($value);
	}
	
	public function getComponentProperty (string $propertyName) {
		return $this->form->getComponentProperty ($propertyName);
	}
	
	public function setComponentProperty (string $propertyName, $value = null) {
		return $this->form->setComponentProperty ($propertyName, $value);
	}
	
	
	//
	// Other Actions
	//
	
	public function getLivewireLoadMethod () {
		return $this->livewireLoad;
	}
	
	public function getLwLoadMethod () {
		return $this->getLivewireLoadMethod();
	}
	
	public function getLivewireDebounceDelay () {
		return $this->livewireDebounce;
	}
	
	public function getLwDebounceDelay () {
		return $this->getLivewireDebounceDelay();
	}
	
	
	public function setLivewireLoadMethod (string $method, string $name = null, int $milliseconds = 750) {
		switch ($method) {
			case 'normal':
				return $this->lw ($name);
			
			case 'lazy':
				return $this->lwLazy ($name);
			
			case 'debounce':
				return $this->lwDebounce ($name, $milliseconds);
		}
		return $this;
	}
	
	public function setLwLoadMethod (string $method, string $name = null, int $milliseconds = 750) {
		return $this->setLivewireLoadMethod ($method, $name, $milliseconds);
	}


}
