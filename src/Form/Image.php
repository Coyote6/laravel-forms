<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;


class Image extends File {
	
	
	protected $template = 'image';
	
		
	public function __construct (string $name, $allowHighDefinitionImages = true) {
		parent::__construct ($name);
		$this->isImage($allowHighDefinitionImages);
	}
	
	
	public function allowHighDefinitionImages () {
		$this->isImage();
		return $this;
	}
	
	public function allowHighDefImgs () {
		return $this->allowHighDefinitionImage();
	}
	
	
	public function disallowHighDefinitionImages () {
		$this->isImage (false);
		return $this;
	}

	
	public function disallowHighDefImgs () {
		return $this->disallowHighDefinitionImage();
	}
	
}


