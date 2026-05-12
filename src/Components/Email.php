<?php


namespace Coyote6\LaravelForms\Components;


use Coyote6\LaravelForms\Components\Input;


class Email extends Input {

    public function __construct (?string $name = null) {
		if (is_string ($name) && trim($name) != '') {
			$this->name = $name;							// Needed for Livewire
			$this->addAttr ('name', $name);
			$this->addAttribute ('type', 'email');
		}
	}
   

}