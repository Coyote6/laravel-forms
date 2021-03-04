<?php

namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\Theme;


class FieldItem {


	use Attributes, Theme;
	
	protected $field;
	
	
	public function __construct ($field, $item = null) {
		$this->field = $field;
		$this->initTheme ($item);
	}	
	
	
	public function field () {
		return $this->field;
	}
	
}

