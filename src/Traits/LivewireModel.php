<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\Field;


trait LivewireModel {
	
	
	protected $livewireModel = '';
	protected $livewireLoad = 'normal';
	
	
	public function livewireModel (string $name) {
		$this->livewireModel = $name;
		if ($this instanceof Field) {
			$this->addAttribute ('wire:model', $name);
		}
	}
	
	public function lwModel (string $name) {
		$this->livewireModel ($name);
	}
	
	public function lw (string $name) {
		$this->livewireModel ($name);
	}
	
	
	public function livewireModelLazy (string $name) {
		$this->livewireModel = $name;
		$this->livewireLoad = 'lazy';
		if ($this instanceof Field) {
			$this->addAttribute ('wire:model.lazy', $name);
		}
	}
	
	public function lwModelLazy (string $name) {
		$this->livewireModel ($name);
	}
	
	public function lwLazy (string $name) {
		$this->livewireModel ($name);
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
