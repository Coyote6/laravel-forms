<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait Theme {
	
	
	public ?string $theme = '';
	
	protected bool $display = true;
	protected bool $error = false;
	
	protected string $styleItem;
	
	
	public function theme (string $theme = null) {
		
		if ($theme == null) {
			$theme = config('forms.default-classes', 'default');
		}
		$this->theme = $theme;
		
		// Reinitiate the theme tags
		// 
		// Note:
		// 		This currently will override any changes made
		//		before calling the theme() method, so be sure
		//		to call theme before any visual methods such
		//		as hideColon() or adding classes.
		//
		//	ToDo:
		//		Create a reinit method that just removes classes
		//		that were initiated during the first init method.
		//
		if (method_exists($this, 'initTags')) {
			$this->initTags();
		}
		if (method_exists($this, 'initTagThemes')) {
			$this->initTagThemes();
		}
		$this->initTheme ('field');
		if (property_exists ($this, 'fields') && is_array ($this->fields)) {
			foreach ($this->fields as &$fields) {
				$fields->theme($theme);
			}
		}
		return $this;
	}

	
	public function initTheme (string $item) {

		$this->styleItem = $item;
		$defaultClasses = config('forms.default-classes', true);
		if ($defaultClasses !== true) {
			$defaultClasses = false;
		}
		
		// Set the style items with default displays and classes.
		switch ($item) {
			
			case 'form':
				if ($defaultClasses) {
					$this->addClass('form');
				}
				$this->addConfigurableClasses ('form');
				break;
				
			case 'form--error-message-container':
				$this->addConfigurableClasses ('error--message-container', 'form');
				break;
				
			case 'form--error-message':
				$this->addConfigurableClasses ('error--message', 'form');		
				break;
				
			case 'form-item':
				if ($defaultClasses) {
					$this->addClass('form-item form-item--' . $this->field()->type);
				}
				$this->addConfigurableClasses ('form-item', $this->field()->type);		
				break;
			
			case 'label-container':
				$this->addConfigurableClasses ('label-container', $this->field()->type);		
				break;
			
			case 'label':
				if ($defaultClasses) {
					$this->addClass('label label--' . $this->field()->type);
				}
				$this->addConfigurableClasses ('label', $this->field()->type);		
				break;
				
			case 'label-text':
				$this->addConfigurableClasses ('label-text', $this->field()->type);		
				break;
				
			case 'field-container':
				if ($defaultClasses) {
					$this->addClass('field-container field-container--' . $this->field()->type);
				}
				$this->addConfigurableClasses ('field-container', $this->field()->type);
				break;
				
			case 'field':
				if ($defaultClasses) {
					$this->addClass('field field--' . $this->type);
				}
				$this->addConfigurableClasses ('field', $this->type);
				break;
				
			case 'error-message-container':
				$this->addConfigurableClasses ('error--message-container', $this->field()->type);
				break;
				
			case 'error-message':
				$this->addConfigurableClasses ('error--message', $this->field()->type);		
				break;
				
			case 'error-icon-container':
				$this->addConfigurableClasses ('error--icon-container', $this->field()->type);
				break;
				
			case 'error-icon':
				$this->setDefaultErrorIconDisplay();
				$this->addConfigurableClasses ('error--icon', $this->field()->type);
				break;
			
			case 'colon':
				$this->setDefaultColonTagDisplay();
				$this->addConfigurableClasses ('colon', $this->field()->type);		
				break;
					
			case 'required-tag':
				if ($defaultClasses) {
					$this->addClass('required required--' . $this->field()->type);
				}
				$this->setDefaultRequiredDisplay();
				$this->addConfigurableClasses ('required', $this->field()->type);	
				break;
		}
		
		return $this;

	}
	
	
	protected function findParentThemeClasses ($theme, $tag, $element, $type = null) {
		$config = 'forms.' . $theme . '--' . $tag . '--' . $element;
		if (is_string ($type) && $type != '') {
			$config .= '--' . $type;
		}
		
		$classes = config ($config, false);
		if ($classes) {
			return $classes;
		}
		else {
			$parentTheme = config ('forms.' . $theme . 'base-theme', false);
			if ($parentTheme) {
				return $this->findParentThemeClasss($parentTheme, $tag, $element);
			}
		}
		return false;
	}
	
	
	protected function addConfigurableClasses (string $element, string $type = null) {
		
		$prefix = '';
		$parentTheme = false;
		if (is_string ($this->theme) && $this->theme != '') {
			$prefix = $this->theme . '--';
			$parentTheme = config ('forms.' . $this->theme . '--parent-theme', false);
		}
		

		$config = 'forms.' . $prefix . 'classes--' . $element;
		$classes = config ($config);
		
		
		
		if ($parentTheme && (is_null ($classes) || $classes === false)) {
			$classes = $this->findParentThemeClasses ($parentTheme, 'classes', $element);
		}
		
		if (is_null ($classes) || $classes === false) {
			$classes = config ('forms.classes--' . $element, '');
		}
		
		if ((is_array ($classes) && count ($classes) > 0) || (is_string ($classes) && trim ($classes) != '')) {
			$this->addClass ($classes);
		}
		
		if (is_string ($type) && $type != '') {
			
			$classes = config ($config . '--' . $type);	
					
			if ($parentTheme && (is_null ($classes) || $classes === false)) {
				$classes = $this->findParentThemeClasses ($parentTheme, 'classes', $element, $type);
			}
		
			if (is_null ($classes) || $classes === false) {
				$classes = config ('forms.classes--' . $element . '--' . $type, '');
			}
			
			if ((is_array ($classes) && count ($classes) > 0) || (is_string ($classes) && trim ($classes) != '')) {
				$this->addClass ($classes);
			}
		}		
	}
	
	
	protected function removeConfigurableClasses (string $element, string $type = null) {
		
		$prefix = '';
		$parentTheme = false;
		if (!is_string ($this->theme) || $this->theme == '') {
			$prefix = $this->theme . '--';
			$parentTheme = config ('forms.' . $this->theme . '--base-theme', false);
		}
		
		$config = 'forms.' . $prefix . 'remove-classes--' . $element;
		$classes = config ($config);
		
		if ($parentTheme && (is_null ($classes) || $classes === false)) {
			$classes = $this->findParentThemeClasses ($parentTheme, 'remove-classes', $element);
		}
		
		if (is_null ($classes) || $classes === false) {
			$classes = config ('forms.remove-classes--' . $element, '');
		}
		if ((is_array ($classes) && count ($classes) > 0) || (is_string ($classes) && trim ($classes) != '')) {
			$this->removeClass ($classes);
		}

		if (is_string ($type) && $type != '') {
			$classes = config ($config . '--' . $type);
			if (is_null ($classes) || $classes === false) {
				$classes = config ('forms.remove-classes--' . $element . '--' . $type, '');
			}
			if ((is_array ($classes) && count ($classes) > 0) || (is_string ($classes) && trim ($classes) != '')) {
				$this->removeClass ($classes);
			}
		}
	
	}
	
	

	
	
	//
	// Tag Displays
	//		
	
	public function displayElement () {
		$this->display = true;
		return $this;
	}
		
		
	public function dontDisplayElement () {
		$this->display = false;
		return $this;
	}
	
	
	public function display () {
		return $this->display;
	}

	
	protected function setDefaultErrorIconDisplay () {
		
		$default = config ('forms.display--error-icon', true);
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else {
			$this->display = true;
		}
	}
	
	
	protected function setDefaultColonTagDisplay () {

		$default = config ('forms.display--colon-tag', false);
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else {
			$this->display = false;
		}
	
	}
	
	
	protected function setDefaultRequiredDisplay () {
		
		$default = config ('forms.display--required-tag', true);
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else {
			$this->display = true;
		}
		
	}


	//
	// Errors
	//
	
	
	public function setError () {
		
		$classes = '';
		$this->error = true;

		switch ($this->styleItem) {
			case 'form-item':
				$this->addConfigurableClasses ('error--form-item', $this->field()->type);
				$this->removeConfigurableClasses ('error--form-item', $this->field()->type);
				break;
			
			case 'label-container':
				$this->addConfigurableClasses ('error--label-container', $this->field()->type);
				$this->removeConfigurableClasses ('error--label-container', $this->field()->type);
				break;
			
			case 'label':
				$this->addConfigurableClasses ('error--label', $this->field()->type);
				$this->removeConfigurableClasses ('error--label', $this->field()->type);
				break;
				
			case 'field-container':
				$this->addConfigurableClasses ('error--field-container', $this->field()->type);
				$this->removeConfigurableClasses ('error--field-container', $this->field()->type);
				break;
				
			case 'field':
				$this->addConfigurableClasses ('error--field', $this->type);
				$this->removeConfigurableClasses ('error--field', $this->type);
				break;
				
		}	

		$this->addClass ($classes);
		return $this;

	}
	
	
	public function hasError () {
		return $this->error;
	}
	

	
}