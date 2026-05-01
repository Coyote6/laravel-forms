<?php
	
	
namespace Coyote6\LaravelForms\Traits;

use Coyote6\LaravelForms\Form\Checkbox;
use Coyote6\LaravelForms\Form\Field;
use Coyote6\LaravelForms\Form\Text;
use Coyote6\LaravelForms\Form\Textarea;


trait LivewireModel {
	
	
	protected $livewireModel = '';
	protected $livewireLoad = 'default';
	protected $livewireDebounce = 750;


	//
	// LW Version
	//
	public static function getLwVersion () {
		return config ('forms.livewire-version', 3);
	}
	
	//
	// LW
	//
	
	public function livewireModel (?string $name = null) {
		$lwFormsDefault = config ('forms.livewire-default-model-binding', 'default');
		switch ($lwFormsDefault) {
			case 'default':
				return $this->livewireModelDefault ($name);
			case 'live':
				return $this->livewireModelLive ($name);
			case 'blur':
				return $this->livewireModelBlur ($name);
			case 'debounce':
				return $this->livewireModelDebounce ($name);
			case 'defer':
				return $this->livewireModelDefer ($name);
		}
		return $this;
	}
	
	public function lwModel (?string $name = null) {
		return $this->livewireModel ($name);
	}
	
	public function lw (?string $name = null) {
		return $this->livewireModel ($name);
	}


	//
	// LW (Default)
	//

	//
	// Use Livewire's default method for model binding.
	//
	public function livewireModelDefault (?string $name = null) {
		if (is_null ($name) || $name == '') {
			$name = $this->name;
		}
		$this->livewireModel = $name;
		$this->livewireLoad = 'default';
		if ($this instanceof Field) {
			$this->addAttribute ('wire:model', $name);
		}
		return $this;
	}
	
	public function lwModelDefault (?string $name = null) {
		return $this->livewireModelDefault ($name);
	}
	
	public function lwDefault (?string $name = null) {
		return $this->livewireModelDefault ($name);
	}


	//
	// Lw Live
	//
	
	public function livewireModelLive (?string $name = null) {
		if (is_null ($name) || $name == '') {
			$name = $this->name;
		}
		$this->livewireModel = $name;
		$this->livewireLoad = 'live';
		
		if ($this instanceof Field) {
			$this->addAttribute ('wire:model.live', $name);	
		}
		return $this;
	}

	public function lwModelLive (?string $name = null) {
		return $this->livewireModelLive ($name);
	}
	
	public function lwLive (?string $name = null) {
		return $this->livewireModelLive ($name);
	}
	
	
	//
	// Lw Blur (Formerly Lazy)
	//
	
	public function livewireModelBlur (?string $name = null) {
		if (is_null ($name) || $name == '') {
			$name = $this->name;
		}
		$this->livewireModel = $name;

		$lwVersion = static::getLwVersion();
		if ($lwVersion >= 3) {
			$this->livewireLoad = 'blur';
		} else {
			$this->livewireLoad = 'lazy';
		}
		if ($this instanceof Field) {
			if ($lwVersion >= 3) {
				$this->addAttribute ('wire:model.blur', $name);
			} else {
				$this->addAttribute ('wire:model.lazy', $name);
			}	
		}
		return $this;
	}

	public function lwModelBlur (?string $name = null) {
		return $this->livewireModelBlur ($name);
	}
	
	public function lwBlur (?string $name = null) {
		return $this->livewireModelBlur ($name);
	}

	// Lazy (Changed to Blur in Livewire 3.0)

	public function livewireModelLazy (?string $name = null) {
		return $this->livewireModelBlur ($name);
	}

	public function lwModelLazy (?string $name = null) {
		return $this->livewireModelBlur ($name);
	}
	
	public function lwLazy (?string $name = null) {
		return $this->livewireModelBlur ($name);
	}
	
	
	//
	// Lw Debounce
	//
	
	public function livewireModelDebounce (?string $name = null, int $milliseconds = 750) {
		if (is_null ($name) || $name == '') {
			$name = $this->name;
		}

		$this->livewireModel = $name;
		$this->livewireLoad = 'debounce';
		$this->livewireDebounce = $milliseconds;

		if ($this instanceof Field) {
			if (static::getLwVersion() >= 3) {
				$this->addAttribute ('wire:model.live.debounce.' . $milliseconds . 'ms', $name);
				if ($this instanceof Text || $this instanceof Textarea) {
					$this->addAttribute ('x-data', "{
						delayed:0, 
						submitted: false,
						name: '" . $this->livewireModel . "',
						element: null,
						init: () => {
							comp = \$wire[this.name];
							el = this;
							\$wire.hook('morph.updated', ({el, comp}) => {
								if (this.submitted) {
									console.log(this.element.form.submit());
									this.submitted = false;

								}
							});
						}
					}");
					$this->addAttribute ('@keyup', "(event)=>{
						if (event.key !== 'Enter') {
							delayed = Date.now();
						}
					}");
					$this->addAttribute ('@keydown', "(event)=>{
						if (event.key === 'Enter') {
							event.preventDefault();
							diff = Date.now() - delayed; 
							this.element = event.target;
							if (diff < $milliseconds) {
								\$wire.set('" . $this->livewireModel . "', event.target.value);
								this.submitted = true;								
								return false;
							}	
						}
						return true;
					}");
				}
			} else {
				$this->addAttribute ('wire:model.debounce.' . $milliseconds . 'ms', $name);
			}
			$this->addAttribute ('wire:loading.attr', 'disabled');
		}

		return $this;
	}
	
	public function lwModelDebounce (?string $name = null, int $milliseconds = 750) {
		return $this->livewireModelDebounce ($name, $milliseconds);
	}
	
	public function lwDebounce (?string $name = null, int $milliseconds = 750) {
		return $this->livewireModelDebounce ($name, $milliseconds);
	}


	//
	// Lw Defer
	//
	
	public function livewireModelDefer (?string $name = null) {
		if (is_null ($name) || $name == '') {
			$name = $this->name;
		}
		$this->livewireModel = $name;
		$this->livewireLoad = 'defer';

		if ($this instanceof Field) {
			$this->addAttribute ('wire:model.defer', $name);
		}
		return $this;
	}

	public function lwModelDefer (?string $name = null) {
		return $this->livewireModelDefer ($name);
	}
	
	public function lwDefer (?string $name = null) {
		return $this->livewireModelDefer ($name);
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
	
	
	public function setLivewireLoadMethod (string $method, ?string $name = null, int $milliseconds = 750) {
		switch ($method) {
			case 'default':
			case 'normal': 									// Old name	
				return $this->lw ($name);
		
			case 'blur':
			case 'lazy':
				return $this->lwBlur ($name);

			case 'live':
				return $this->lwLive ($name);

			case 'defer':
				if (static::getLwVersion() >= 3) {
					return $this->lw ($name);
				}
				return $this->lwDefer ($name);

			case 'debounce':
				return $this->lwDebounce ($name, $milliseconds);
		}
		return $this;
	}
	
	public function setLwLoadMethod (string $method, ?string $name = null, int $milliseconds = 750) {
		return $this->setLivewireLoadMethod ($method, $name, $milliseconds);
	}


}
