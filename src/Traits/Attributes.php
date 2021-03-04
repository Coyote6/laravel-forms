<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait Attributes {
	
	
	protected $attributes = [];
	protected $classes = [];
	
	
	public function addAttribute (string $name, $value = true) {
		if (!is_string ($value) && !is_numeric ($value) && !is_bool ($value)) {
			return;
		}
		$this->attributes[$name] = $value;
	}
	
	public function addAttr (string $name, $value) {
		$this->addAttribute ($htmlAttribute);
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
	}

	public function removeAttr (string $name) {
		$this->removeAttribute ($name);
	}	
	
	
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
	}
	
	
	public function resetClasses () {
		$this->classes = [];
	}

	
	public function renderAttributes () {
		
		
		$attrs = [];
		if (!empty ($this->classes)) {
			$attrs[] = 'class="' . implode (' ', $this->classes) . '"';
		}
		
		foreach ($this->attributes as $name => $value) {
			if ($name == 'class') {
				continue;
			}
			// Check for single value attributes.
			if (in_array ($name, ['checked', 'required', 'multiple']) && $value) {
					$attrs[] = $name;
			}
			// Translate Placeholder Text, Descriptions, Captions, & Alt Texts
			else if (in_array ($name, ['placeholder', 'description', 'caption', 'alt'])) {
				$value = __($value);
				$attrs[] = $name . '="' . str_replace ('"', '\"', $value) . '"';
			}
			else {
				$attrs[] = $name . '="' . str_replace ('"', '\"', $value) . '"';
			}
		}

		return implode (' ', $attrs);
	}
	
	
}