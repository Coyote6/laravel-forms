<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;

class File extends input {
	
	
	protected $type = 'file';
	protected $template = 'file';
	
	
	protected function defaultRules () {
		return ['file'];
	}
	
	
	public function isImage ($highDef = true) {
		if ($highDef) {
			$this->rules['mimes'] = 'mimes:jpg,jpeg,gif,png,bmp,svg,webp,heic';
			$this->addAttribute('accept', '.jpg,.jpeg,.gif,.png,.bmp,.svg,.webp,.heic');
			if (isset ($this->rules['image'])) {
				unset ($this->rules['image']);
			}
		}
		else {
			$this->rules['image'] = 'image';
			$this->addAttribute('accept', '.jpg,.jpeg,.gif,.png,.bmp,.svg,.webp');
			if (isset ($this->rules['mimes'])) {
				unset ($this->rules['mimes']);
			}
		}
		return $this;
	}
	
	
	public function multiple () {
		$this->addAttribute('multiple');
		return $this;
	}
	
	
	public function allowedMimes ($mimes = null) {
		$allowed = false;
		if (is_array ($mimes)) {
			foreach ($mimes as &$mime) {
				if (is_string ($mime) && $mime != '') {
					$mime = trim ($mime);
				}
				else {
					unset ($mime);
				}
			}
			$allowed = implode(',', $mimes);
		}
		else if (is_string ($mimes)) {
			$allowed = $mimes;
		}
		if ($allowed) {
			$this->rules['mimes'] = $mimes;
			$split = explode(',',$mimes);
			foreach ($split as &$mime) {
				$mime = '.' . $mime;
			}
			$mimes = implode(',', $split);
			$this->addAttribute('accept', $mimes);
		}
		return $this;
	} 
	
	
}


