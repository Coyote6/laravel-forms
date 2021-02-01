<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;

class File extends input {
	
	
	protected $type = 'file';
	
	
	public function isImage ($highDef = true) {
		$this->rules['allowed'] = 'jpg,jpeg,gif,png';
		if ($highDef === true) {
			$this->rules['allowed'] .= ',heic';
		}
	}
	
	
}


