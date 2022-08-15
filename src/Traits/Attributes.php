<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\AttributeBag;


trait Attributes {
	
	
	protected $attributes = [];
	protected $classes = [];
	
	
	//
	// Generic Attributes
	//
	
	public function addAttribute (string $name, $value = true) {
		if (is_string ($value) || is_numeric ($value) || is_bool ($value)) {
			$this->attributes[$name] = $value;
		}
		return $this;
	}
	
	public function addAttr (string $name, $value = true) {
		return $this->addAttribute ($name, $value);
	}
	
	public function attribute (string $name, $value = true) {
		return $this->addAttribute ($name, $value);
	}
	
	public function attr (string $name, $value = true) {
		return $this->addAttribute ($name, $value);
	}
	
	
	public function getAttribute (string $name) {
		if (isset ($this->attributes[$name])) {
			return $this->attributes[$name];
		}
	}
	
	public function getAttr (string $name) {
		return $this->getAttribute ($name);
	}	
	
	
	public function hasAttribute (string $name) {
		if (isset ($this->attributes[$name])) {
			return true;
		}
		return false;
	}
	
	
	public function removeAttribute (string $name) {
		if (isset ($this->attributes[$name])) {
			unset ($this->attributes[$name]);
		}
		return $this;
	}
	

	public function removeAttr (string $name) {
		return $this->removeAttribute ($name);
	}	
	
	
	//
	// Classes
	//
	
	public function addClass ($classes) {
		
		if (is_array ($classes)) {
			foreach ($classes as $class) {
				$this->addClass ($class);
			}
		}
		else if (is_string ($classes)) {
			$classStrs = explode (' ', $classes);
			foreach ($classStrs as $str) {
				$str = trim ($str);
				if ($str != '') {
					$this->classes[$str] = $str;
				}
			}
		}
		return $this;
	
	}
	
	
	public function removeClass ($classes) {
		
		if (is_array ($classes)) {
			foreach ($classes as $class) {
				$this->removeClass ($class);
			}
		}
		else if (is_string ($classes)) {
			$classStrs = explode (' ', $classes);
			foreach ($classStrs as $str) {
				$str = trim ($str);
				if ($str != '' && isset ($this->classes[$str])) {
					unset ($this->classes[$str]);
				}
			}
		}
		return $this;

	}
	
	
	public function resetClasses () {
		$this->classes = [];
		return $this;
	}
	
	
	//
	// Common Attributes
	//
	public function placeholder (string $value = null) {
		if (is_null ($value) || $value == '') {
			if (!is_null ($this->label) && $this->label != '') {
				$value = $this->label;
			}
			else {
				$value = ucfirst ($this->name);
			}
		}
		return $this->addAttribute ('placeholder', $value);
	}
	
	public function autocomplete (string $value = null) {
		if (is_null ($value) || $value == '') {
			$value = $this->type;
		}
		return $this->addAttribute ('autocomplete', $value);
	}
	
	public function disable () {
		return $this->addAttribute ('disabled', true);
	}
	
	public function disabled () {
		return $this->disable();
	}
	
	public function enable () {
		if ($this->hasAttr ('disable')) {
			$this->removeAttribute ('disabled');
		}
		return $this;
	}
	
	public function enabled () {
		return $this->enable();
	}
	
	//
	// Actions
	//

	
	public function renderAttributes () {
		
		$attrs = [];
		if (!empty ($this->classes)) {
			$attrs['class'] = implode (' ', $this->classes);
		}
		
		foreach ($this->attributes as $name => $value) {
			
			if ($name == 'class') {
				continue;
			}

			// Translate Placeholder Text, Descriptions, Captions, & Alt Texts
			if (in_array ($name, ['placeholder', 'description', 'caption', 'alt'])) {
				$attrs[$name] = __($value);
			}
			else {
				$attrs[$name] = $value;
			}
		}
		
		return new AttributeBag ($attrs);
		
	}
	
	
}