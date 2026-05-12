<?php
	
	
namespace Coyote6\LaravelForms\Traits;

use Coyote6\LaravelForms\Components\Description;

trait HasDescription {
	
	public Description|false $description = false;

	// Set Description
	//
	// @param string $content - The description text to display for this field.
	// @return self
	//
	public function setDescription (Description|string $content): self {
		if ($content instanceof Description) {
			$this->description = $content;
			return $this;
		}	
		$this->description = new Description($content);
		return $this;
	}

	//
	// @alias setDescription
	// @param string $content - The description text to display for this field.
	// @return self
	//
	public function description (Description|string $content): self {
		return $this->setDescription($content);
	}

	//
	// @alias setDescription
	// @param string $content - The description text to display for this field.
	// @return self
	//
	public function desc (Description|string $content): self {
		return $this->setDescription($content);
	}

	// Get Description
	//
	// @return string|false
	//
	public function getDescription (): Description|false {
		return $this->description;
	}

	//
	// @alias getDescription
	// @return string|false
	//
	public function getDesc (): Description|false {
		return $this->description;
	}

	//
	// Help Text
	//
	// Alias for description, but more intuitive for some fields.
	// This is a carryover from the previous version of the package.
	//

	// @deprecated Use description instead.
	// @alias description
	// @return self
	//
	public function helpText (string $content): self {
		return $this->description($content);
	}

	//
	// @deprecated Use getDescription instead.
	// @alias getDescription
	// @return string|false
	//
	public function getHelpText (): Description|false {
		return $this->description;
	}
	
}