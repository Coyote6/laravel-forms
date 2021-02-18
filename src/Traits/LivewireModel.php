<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait LivewireModel {
	
	
	protected $livewireModel = '';
	
	
	public function livewireModel (string $name) {
		$this->livewireModel = $name;
		$this->addAttribute ('wire:model', $name);
	}
	
	public function lwModel (string $name) {
		$this->livewireModel ($name);
	}
	
	public function lw (string $name) {
		$this->livewireModel ($name);
	}
	
	
	public function getLivewireModel () {
		return $this->livewireModel;
	}
	
	public function getLwModel () {
		return $this->getLivewireModel();
	}
		
	
}
