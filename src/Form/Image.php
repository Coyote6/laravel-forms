<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;


class Image extends File {
		
	public function __construct (string $name, $allowHighDefinitionImages = true) {
		parent::__construct ($name);
		$this->isImage($allowHighDefinitionImages);
	}
	
	
	public function allowHighDefinitionImages () {
		$this->isImage();
	}
	
	public function allowHighDefImgs () {
		$this->allowHighDefinitionImage();
	}
	
	
	public function disallowHighDefinitionImages () {
		$this->isImage (false);
	}
	
	public function disallowHighDefImgs () {
		$this->disallowHighDefinitionImage();
	}
	
}


