<?php
	
	
namespace Coyote6\LaravelForms\Traits;

use Coyote6\LaravelForms\Components\Label;

trait HasLabel {
	
	public Label|false $label = false;

	// Set Label
	//
	// @param Label|string $content - The label component or text to display for this field.
	// @return self
	//
	public function setLabel (Label|string $content) {
		if ($content instanceof Label) {
			$this->label = $content;
			return $this;
		} 
		
		$this->label = new Label($content);
		return $this;
	}

	//
	// @alias setLabel
	// @param Label|string $content - The label component or text to display for this field.
	// @return self
	//
	public function label (Label|string $content): self {
		return $this->setLabel($content);
	}


	// Get Label
	//
	// @return Label|false
	//
	public function getLabel (): Label|false {
		return $this->label;
	}

	
}