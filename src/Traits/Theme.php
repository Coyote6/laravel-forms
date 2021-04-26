<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait Theme {
	
	
	public ?string $theme = '';
	
	protected bool $display = true;
	protected bool $error = false;
	
	protected string $styleItem;

	
	public function initTheme (string $item) {

		$this->styleItem = $item;
		$defaultClasses = config('laravel-forms.default-classes', true);
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
					$this->addClass('required' . $this->field()->type);
				}
				$this->setDefaultRequiredDisplay();
				$this->addConfigurableClasses ('required', $this->field()->type);	
				break;
		}
		
		return $this;

	}
	
	
	protected function addConfigurableClasses (string $element, string $type = null) {
		
		$prefix = '';
		if (is_string ($this->theme) && $this->theme != '') {
			$prefix = $this->theme . '--';
		}
		
		$config = 'laravel-forms.' . $prefix . 'classes--' . $element;
		$classes = config ($config);
		if (is_null ($classes) || !$classes) {
			$classes = config ('laravel-forms.classes--' . $element, '');
		}
		if ((is_array ($classes) && count ($classes) > 0) || (is_string ($classes) && trim ($classes) != '')) {
			$this->addClass ($classes);
		}
		
		if (is_string ($type) && $type != '') {
			$classes = config ($config . '--' . $type);	
			if (is_null ($classes) || !$classes) {
				$classes = config ('laravel-forms.classes--' . $element . '--' . $type, '');
			}
			if ((is_array ($classes) && count ($classes) > 0) || (is_string ($classes) && trim ($classes) != '')) {
				$this->addClass ($classes);
			}
		}		
	}
	
	
	protected function removeConfigurableClasses (string $element, string $type = null) {
		
		$prefix = '';
		if (!is_string ($this->theme) || $this->theme == '') {
			$prefix = $this->theme . '--';
		}
		
		$config = 'laravel-forms.' . $prefix . 'remove-classes--' . $element;
		$classes = config ($config);
		if (is_null ($classes) || !$classes) {
			$classes = config ('laravel-forms.remove-classes--' . $element, '');
		}
		if ((is_array ($classes) && count ($classes) > 0) || (is_string ($classes) && trim ($classes) != '')) {
			$this->removeClass ($classes);
		}

		if (is_string ($type) && $type != '') {
			$classes = config ($config . '--' . $type);
			if (is_null ($classes) || !$classes) {
				$classes = config ('laravel-forms.remove-classes--' . $element . '--' . $type, '');
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
		
		$default = config ('laravel-forms.display--error-icon', true);
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else {
			$this->display = true;
		}
	}
	
	
	protected function setDefaultColonTagDisplay () {

		$default = config ('laravel-forms.display--colon-tag', false);
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else {
			$this->display = false;
		}
	
	}
	
	
	protected function setDefaultRequiredDisplay () {
		
		$default = config ('laravel-forms.display--required-tag', true);
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