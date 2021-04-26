<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\Field;


trait LivewireModel {
	
	
	protected $livewireModel = '';
	protected $livewireLoad = 'normal';
	
	
	public function livewireModel (string $name = null) {
		if (is_null ($name) || $name == '') {
			$name = $this->name;
		}
		$this->livewireModel = $name;
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
	
	
	public function getLivewireModel () {
		return $this->livewireModel;
	}
	
	public function getLwModel () {
		return $this->getLivewireModel();
	}
	
	public function getLw () {
		return $this->getLivewireModel();
	}
		
	
}
