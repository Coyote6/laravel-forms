<?php

namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Traits\Attributes;
use Coyote6\LaravelForms\Traits\Theme;


class FieldItem {


	use Attributes, Theme;
	
	protected $field;
	protected $item;
	
	
	public function __construct ($field, $item = null) {
		$this->field = $field;
		$this->item = $item;
	}	

	public function init () {
		$this->initTheme ($this->item);
	}	
	
	public function field () {
		return $this->field;
	}
	
}

