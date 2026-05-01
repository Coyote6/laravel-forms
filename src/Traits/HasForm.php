<?php

trait HasForm {
    
    //
	// Allow all special form values to be added.
	//
	public function __set ($name, $value) {

		// Allow noLivewireRules to be set dynamically from the form components.
		//
		// Needed for Livewire 2.
		//
		if ($name == 'noLivewireRules') {
			$this->noLivewireRules = $value;
		}
        
    }

}