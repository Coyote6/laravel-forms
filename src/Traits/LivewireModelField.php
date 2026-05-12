<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Traits\HasInput;
use Coyote6\LaravelForms\Traits\LivewireModelAbstract;


trait LivewireModelField {

	use LivewireModelAbstract,
        HasInput;
	


	//
	// LW
	//
	
    // Livewire Model
    //
    // Sets the Livewire model for this field. This will determine which property on the Livewire component this field is bound to, and how it updates.
    //
    // @alias LivewireModelSelf
    // @param string|null $name - Optional name to set for the Livewire model. If not provided, it will use the field's name property.
    // @return self
    //
	public function livewireModel (?string $name = null): self {
		$this->validateInputSet('An input must be set on the field prior to adding a Livewire model. If you are attempting to call Livewire on the field itself, use the livewireModelSelf() version of the call.');
        $this->input->livewireModelSelf ($name);
		return $this;
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
        $this->validateInputSet('An input must be set on the field prior to adding a Livewire model. If you are attempting to call Livewire on the field itself, use the livewireModelSelf() version of the call.');
		$this->input->livewireModelDefaultSelf ($name);
        return $this;
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
        $this->validateInputSet('An input must be set on the field prior to adding a Livewire model. If you are attempting to call Livewire on the field itself, use the livewireModelSelf() version of the call.');
		$this->input->livewireModelLiveSelf ($name);
        return $this;
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
        $this->validateInputSet('An input must be set on the field prior to adding a Livewire model. If you are attempting to call Livewire on the field itself, use the livewireModelSelf() version of the call.');
		$this->input->livewireModelBlurSelf ($name);
        return $this;
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
		$this->validateInputSet('An input must be set on the field prior to adding a Livewire model. If you are attempting to call Livewire on the field itself, use the livewireModelSelf() version of the call.');
        $this->input->livewireModelDebounceSelf ($name, $milliseconds);
        return $this;
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
		$this->validateInputSet('An input must be set on the field prior to adding a Livewire model. If you are attempting to call Livewire on the field itself, use the livewireModelSelf() version of the call.');
        $this->input->livewireModelDeferSelf ($name, $milliseconds);
        return $this;
	}

}
