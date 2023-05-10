<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;


class Image extends File {
	
	
	protected $template = 'image';
	protected $previewStyle = 'preview';
	public $displayFilename = false;
	
		
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


