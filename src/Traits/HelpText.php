<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait HelpText {
	
	public $helpText;

	public function helpText (string $value) {
		$this->helpText = $value;
		return $this;
	}
	
}