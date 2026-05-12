<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Support\FormHelper;


trait LivewireModel {
	
	
	protected string|false $livewireModel = false;
	protected string $livewireLoad = 'default';
	protected int $livewireDebounce = 750;
    protected string|false $livewireModelAttribute = false;
    protected bool $livewireModelDeep = false;


	//
	// Livewire
	//



    // Get Livewire Model Name
    //
    // Retrieves the name of the Livewire model that this field is bound to.
    //
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return string
    //
    protected function getLivewireModelName (?string $name = null): string {
        if (is_null ($name) || $name == '') {
            if ((isset ($this->name) && $this->name != '')) {
                $name = $this->name;
            }
            else {
                trigger_error ('Livewire model name could not be determined. Please provide a name or ensure the component has a name property set.', E_USER_WARNING);
            }
        }
        return $name;
    }


    // Update Livewire Model Attribute
    //
    // Updates the name of the Livewire model attribute
    //
    // @param string $name - The new name of the attribute
    // @return self
    //
    protected function updateLivewireModelAttribute (): self {
        
        // If the Livewire model attribute is set remove it.
        if (is_string ($this->livewireModelAttribute)) {
            $this->removeAttr ($this->livewireModelAttribute);
        }

        // Ordered by most likely to be called directly.
        $attr = '';
        switch ($this->livewireLoad) {

            case 'default':
                $attr = 'wire:model';
                break;

            case 'blur':
                $attr = 'wire:model.blur';
                break;

            // Lw 2
            case 'lazy':
                $attr = 'wire:model.lazy';
                break;
            
            case 'debounce':
                $attr = 'wire:model.live.debounce.' . $this->livewireModelDebounce . 'ms';
                break;

            case 'live':
                $attr = 'wire:model.live';
                break;

            case 'defer':
                $attr = 'wire:model.defer';
                break;

            default:
                $attr = 'wire:model';
                break;


        }

        if ($this->livewireModelDeep) {
            $attr .= '.deep';
        }
        $this->livewireModelAttribute = $attr;
		$this->addAttribute ($this->livewireModelAttribute, $this->livewireModel);
        return $this;
    }
	

	//
	// LW
	//
	
    // Livewire Model
    //
    // Sets the Livewire model for this field. This will determine which property on the Livewire component this field is bound to, and how it updates.
    //
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function livewireModel (?string $name = null): self {
		$lwFormsDefault = config ('forms.livewire--default-model-binding', 'default');
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
	

    // Lw Model
    //
    // @alias livewireModel
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lwModel (?string $name = null): self {
		return $this->livewireModel ($name);
	}
	

    // Lw
    //
    // @alias livewireModel
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lw (?string $name = null): self {
		return $this->livewireModel ($name);
	}



    //
	// LW (Default)
    //
	// Use Livewire's default method for model binding.
	//


    // Livewire Model Default
    //
    // Sets the Livewire model for this field using Livewire's default method for model binding.
    //
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    // 
	public function livewireModelDefault (?string $name = null): self {
		$this->livewireModel = $this->getLivewireModelName($name);
		$this->livewireLoad = 'default';
        $this->updateLivewireModelAttribute();
		return $this;
	}
	

    // Lw Model Default
    //
    // @alias livewireModelDefault
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    // 
	public function lwModelDefault (?string $name = null): self {
		return $this->livewireModelDefault ($name);
	}
	

    // Lw Default
    //
    // @alias livewireModelDefault
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    // 
	public function lwDefault (?string $name = null): self {
		return $this->livewireModelDefault ($name);
	}


	//
	// Lw Live
	//
	

    // Livewire Model Live
    //
    // Sets the Livewire model for this field using Livewire's live method for model binding. This will update the Livewire property on every keystroke or change event.
    //
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function livewireModelLive (?string $name = null): self {
		$this->livewireModel = $this->getLivewireModelName($name);
		$this->livewireLoad = 'live';
        $this->updateLivewireModelAttribute();
		return $this;
	}


    // Lw Model Live
    //
    // @alias livewireModelLive
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lwModelLive (?string $name = null): self {
		return $this->livewireModelLive ($name);
	}
	

    // Lw Model Live
    //
    // @alias livewireModelLive
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lwLive (?string $name = null): self {
		return $this->livewireModelLive ($name);
	}
	
	
	//
	// Lw Blur (Formerly Lazy)
	//
	

    // Livewire Model Blur
    //
    // Sets the Livewire model for this field using Livewire's blur method for model binding. This will update the Livewire property when the field loses focus (on blur event).
    // Dev Note: 
    //      In Livewire 3.0, the "lazy" modifier was changed to "blur" to better reflect its behavior. 
    //      This method will use "wire:model.blur" for Livewire 3.0 and above, and "wire:model.lazy" for Livewire 2.x.
    //
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function livewireModelBlur (?string $name = null): self {
		$this->livewireModel = $this->getLivewireModelName($name);
        if (FormHelper::lwVersion() >= 3) {
            $this->livewireLoad = 'blur';
            $this->updateLivewireModelAttribute();
        } 
        else {
            $this->livewireLoad = 'lazy';
            $this->updateLivewireModelAttribute();
        }	
		return $this;
	}


    // Lw Model Blur
    //
    // @alias livewireModelBlur
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lwModelBlur (?string $name = null): self {
		return $this->livewireModelBlur ($name);
	}
	

    // Lw Model Blur
    //
    // @alias livewireModelBlur
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lwBlur (?string $name = null): self {
		return $this->livewireModelBlur ($name);
	}


    // Livewire Model Lazy (Changed to Blur in Livewire 3.0)
    //
    // @alias livewireModelBlur
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function livewireModelLazy (?string $name = null): self {
		return $this->livewireModelBlur ($name);
	}


    // Lw Model Lazy (Changed to Blur in Livewire 3.0)
    //
    // @alias livewireModelBlur
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lwModelLazy (?string $name = null): self {
		return $this->livewireModelBlur ($name);
	}
	

    // Lw Lazy (Changed to Blur in Livewire 3.0)
    //
    // @alias livewireModelBlur
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lwLazy (?string $name = null): self {
		return $this->livewireModelBlur ($name);
	}
	
	
	//
	// Lw Debounce
	//
	
    // Livewire Model Debounce
    //
    // Sets the Livewire model for this field using Livewire's debounce method for model binding. 
    // This will update the Livewire property after the user stops typing for a specified amount of time (debounce delay).
    //
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @param int $milliseconds - The debounce delay in milliseconds. Default is 750ms.
    // @return self
    //
	public function livewireModelDebounce (?string $name = null, int $milliseconds = 750): self {

		$this->livewireModel = $this->getLivewireModelName($name);
		$this->livewireLoad = 'debounce';
		$this->livewireDebounce = $milliseconds;
        $this->updateLivewireModelAttribute();
/*
		if ($this instanceof Field) {
			if (FormHelper::lwVersion() >= 3) {
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
        */

		return $this;
	}
	

    // Livewire Model Debounce
    //
    // @alias livewireModelDebounce
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @param int $milliseconds - The debounce delay in milliseconds. Default is 750ms.
    // @return self
    //
	public function lwModelDebounce (?string $name = null, int $milliseconds = 750): self {
		return $this->livewireModelDebounce ($name, $milliseconds);
	}
	

    // Livewire Model Debounce
    //
    // @alias livewireModelDebounce
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @param int $milliseconds - The debounce delay in milliseconds. Default is 750ms.
    // @return self
    //
	public function lwDebounce (?string $name = null, int $milliseconds = 750): self {
		return $this->livewireModelDebounce ($name, $milliseconds);
	}


	//
	// Lw Defer
	//
	
    // Livewire Model Defer
    //
    // Sets the Livewire model for this field using Livewire's defer method for model binding. 
    // This will update the Livewire property only when an action is taken that triggers an update, 
    // such as clicking a button with wire:click or submitting the form. This is useful for fields 
    // that don't need to update in real-time and can wait until the user is finished with their input.
    //
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function livewireModelDefer (?string $name = null): self {
		$this->livewireModel = $this->getLivewireModelName($name);
		$this->livewireLoad = 'defer';
        $this->updateLivewireModelAttribute();
		return $this;
	}


    // Lw Model Defer
    //
    // @alias livewireModelDefer
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lwModelDefer (?string $name = null): self {
		return $this->livewireModelDefer ($name);
	}
	

    // Lw Model Defer
    //
    // @alias livewireModelDefer
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function lwDefer (?string $name = null): self {
		return $this->livewireModelDefer ($name);
	}
	
	
	//
	// Retrieval
	//
	

    // Get Livewire Model
    //
    // Retrieves the name of the Livewire model that this field is bound to. 
    // This can be used to determine if the field has a Livewire model set, and what it is.
    //
    // @return string|null
    //
	public function getLivewireModel (): ?string {
		return $this->livewireModel;
	}
	

    // Get Lw Model
    //
    // @alias getLivewireModel
    // @return string|null
    //
	public function getLwModel (): ?string {
		return $this->getLivewireModel();
	}
	

    // Get Lw
    //
    // @alias getLivewireModel
    // @return string|null
    //
	public function getLw (): ?string {
		return $this->getLivewireModel();
	}
		
	
	//
	// Checks
	//
	
    
    // Is Livewire
    //
    // Checks if this field has a Livewire model set. This can be used to conditionally render or handle the field differently if it is using Livewire.
    //
    // @return bool
    //
	public function isLivewire (): bool {
		if (is_string ($this->livewireModel) && $this->livewireModel != '') {
			return true;
		}
		return false;
	}
	
	
    // Is Lw
    //
    // @alias isLivewire
    // @return bool
    //
	public function isLw (): bool {
		return $this->isLivewire();
	}
	
	
	//
	// Component & Component Properties
	//
/*
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
	*/
	
	//
	// Other Actions
	//


    // Deep
    //
    // Sets the listener for nested Livewire components sending events to the parent.
    //
    // @return self
    //
    public function deep (): self {

        // Add deep to the Livewire attribute.
        $this->livewireModelDeep = true;
        $this->updateLivewireModelAttribute();
        return self;

    }


    // Shallow
    //
    // Removes the listener for nested Livewire components sending events to the parent.
    //
    // @return self
    //
    public function shallow (): self {

        // Remove deep to the Livewire attribute.
        $this->livewireModelDeep = false;
        $this->updateLivewireModelAttribute();
        return self;

    }
	
    // Get Livewire Load Method
    //
    // Retrieves the Livewire load method that is currently set for this field. 
    // This indicates how the Livewire model updates (e.g., on every keystroke, on blur, with debounce, etc.).
    //
    // @return string
    //
	public function getLivewireLoadMethod (): string  {
		return $this->livewireLoad;
	}
	

    // Get Lw Load Method
    //
    // @alias getLivewireLoadMethod
    // @return string
    //
	public function getLwLoadMethod (): string {
		return $this->getLivewireLoadMethod();
	}
	

    // Get Livewire Debounce Delay
    //
    // If the Livewire load method is set to debounce, this method retrieves the debounce delay in milliseconds.
    // If the load method is not debounce, this may return null or a default value.
    //
    // @return int|null
    //
	public function getLivewireDebounceDelay (): ?int {
		return $this->livewireDebounce;
	}
	

    // Get Lw Debounce Delay
    //
    // @alias getLivewireDebounceDelay
    // @return int|null
    //
	public function getLwDebounceDelay (): ?int {
		return $this->getLivewireDebounceDelay();
	}
	
	
    // Set Livewire Load Method
    //
    // Sets the Livewire load method for this field, which determines how the Livewire model
    // updates in response to user input. This method can be used to change the load method 
    // after it has been set, or to set it directly without using the specific methods for each load type.
    //
    // @param string $method - The Livewire load method to set. Valid values are 'default', 'live', 'blur', 'debounce', and 'defer'.
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @param int $milliseconds - The debounce delay in milliseconds, if the debounce method is used. Default is 750ms.
    // @return self
    //
	public function setLivewireLoadMethod (string $method, ?string $name = null, int $milliseconds = 750): self {
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
				if (FormHelper::lwVersion() >= 3) {
					return $this->lw ($name);
				}
				return $this->lwDefer ($name);

			case 'debounce':
				return $this->lwDebounce ($name, $milliseconds);
		}
		return $this;
	}
	

    // Set Lw Load Method
    //
    // @alias setLivewireLoadMethod
    // @param string $method - The Livewire load method to set. Valid values are 'default', 'live', 'blur', 'debounce', and 'defer'.
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @param int $milliseconds - The debounce delay in milliseconds, if the debounce method is used. Default is 750ms.
    // @return self
    //
	public function setLwLoadMethod (string $method, ?string $name = null, int $milliseconds = 750): self {
		return $this->setLivewireLoadMethod ($method, $name, $milliseconds);
	}


}
