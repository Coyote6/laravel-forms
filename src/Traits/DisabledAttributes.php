<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Traits\Attributes;


trait DisabledAttributes {


	use Attributes;
	
	
	// Disabled Only
	//
	// Sets the disabled attribute on the field, which will disable the field in the browser.
	// This disables the field without writing any rules.
	//
	// @see Coyote6\LaravelForms\Traits\Rules->disabled()
	//
	// @return self
	//
	public function disabledOnly (): self {
		return $this->setAttribute ('disabled', true);
	}


	// Disable Only
	//
	// @alias disabledOnly
	// @return self
	//
	public function disableOnly (): self {
		return $this->disabledOnly();
	}
	

	// Is Disabled
	//
	// Checks to see if the disabled attribute is set on the field.
	//
	// @return bool
	//
	public function isDisabled (): bool {
		return ($this->hasAttr ('disabled') && $this->getAttr ('disabled') !== false);
	}
	

	// Enable
	//
	// Removes the disabled attribute from the field, which will enable the field in the browser.
	// This removes the disabled attribute only without affecting any rules.
	//
	// @see Coyote6\LaravelForms\Traits\Rules->enabled()
	//
	// @return self
	//
	public function enabledOnly (): self {
		if ($this->hasAttr ('disabled')) {
			$this->removeAttribute ('disabled');
		}
		return $this;
	}
	

	// Enable Only
	//
	// @alias enabledOnly
	// @return self
	//
	public function enableOnly (): self {
		return $this->enabledOnly();
	}


	// Is Enabled
	//
	// Checks to see if the disabled attribute is set on the field.
	//
	// @return bool
	//
	public function isEnabled (): bool {
		return (!$this->hasAttr ('disabled') || $this->getAttr ('disabled') === false);
	}
	
}