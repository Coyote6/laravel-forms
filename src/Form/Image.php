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
	

	protected function getPreviewUrl ($value) {
		
		$accessTimes = $this->getTempAccessTimes();

		if (is_object ($value)) {
			if (class_exists ('\Livewire\TemporaryUploadedFile') && $value instanceof \Livewire\TemporaryUploadedFile) {
				if (class_exists ('Coyote6\LaravelMedia\Models\Image')) {
					
					$hash = md5 ($value->getFilename());
					if (!isset ($accessTimes[$hash])) {
						$accessTimes[$hash] = $this->setTempAccessTime($hash);
					}
					
					return URL::temporarySignedRoute(
			        	'media.temporary-preview', $accessTimes[$hash], ['style' => $this->previewStyle, 'slug' => $this->getFilenameForUrl ($value->getFilename())]
			        );
				}
				return $value->temporaryUrl();
			}
			else if (class_exists ('Coyote6\LaravelMedia\Models\Image') && $value instanceof \Coyote6\LaravelMedia\Models\Image) {
				if (class_exists ('Coyote6\LaravelMedia\Models\Image') && \Coyote6\LaravelMedia\Models\ImageStyle::exists ($this->previewStyle)) {
					return $value->imageStyleUrl ($this->previewStyle);
				}
				else {
					return $value->url();
				}
			}
			else if (class_exists ('Coyote6\LaravelMedia\Concerns\Url') && $value instanceof \Coyote6\LaravelMedia\Concerns\Url) {
				if (class_exists ('Coyote6\LaravelMedia\Models\Image') && \Coyote6\LaravelMedia\Models\ImageStyle::exists ($this->previewStyle)) {
					return $value->imageStyleUrl ($this->previewStyle);
				}
				else {
					return $value->url();
				}
			}
		}
		else if (is_string ($value) && $value != '') {
			return $value;
		}
			
	}

}


