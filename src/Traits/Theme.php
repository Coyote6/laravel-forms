<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait Theme {
	
	
	protected $theme;
	protected $defaultClasses = true;
	protected $display = true;
	protected $error = false;
	
	protected $styleItem;



	public function setTheme (string $theme = null) {
		if (in_array ($theme, ['coyote6', 'tailwind', 'drupal', 'bootstrap'])) {
			$this->theme = $theme;
		}
	}
	
	
	public function setDefaultClasses (bool $set) {
		$this->defaultClasses = $set;
	}
	
	
	
	public function initTheme (string $item) {
		
		$theme = config ('laravel-forms.theme', null);
		$this->setTheme ($theme);
		
		$default = config ('laravel-forms.default-classes', true);
		$this->setDefaultClasses ($default);
		
		$this->styleItem = $item;
		
		// Set the style items with default displays and classes.
		switch ($item) {
			
			case 'form':
				$this->setDefaultFormAttributes();
				break;
				
			case 'form-item':
				$this->setDefaultFormItemDisplay();
				$this->setDefaultFormItemAttributes();
				break;
			
			case 'label-container':
				$this->setDefaultLabelContainerDisplay();
				$this->setDefaultLabelContainerAttributes();
				break;
			
			case 'label':
				$this->setDefaultLabelDisplay();
				$this->setDefaultLabelAttributes();
				break;
				
			case 'label-text':
				$this->setDefaultLabelTextDisplay();
				$this->setDefaultLabelTextAttributes();
				break;
				
			case 'field-container':
				$this->setDefaultFieldContainerDisplay();
				$this->setDefaultFieldContainerAttributes();
				break;
				
			case 'field':
				$this->setDefaultFieldAttributes();
				break;
				
			case 'error-message-container':
				$this->setDefaultErrorMessageContainerDisplay();
				$this->setDefaultErrorMessageContainerAttributes();
				break;
				
			case 'error-message':
				$this->setDefaultErrorMessageAttributes();
				break;
				
			case 'error-icon-container':
				$this->setDefaultErrorIconContainerDisplay();
				$this->setDefaultErrorIconContainerAttributes();
				break;
				
			case 'error-icon':
				$this->setDefaultErrorIconDisplay();
				$this->setDefaultErrorIconAttributes();
				break;
			
			case 'colon':
				$this->setDefaultColonTagDisplay();
				$this->setDefaultColonAttributes();
				break;
					
			case 'required-tag':
				$this->setDefaultRequiredDisplay();
				$this->setDefaultRequiredAttributes();
				break;
		}
	}
	
	
	//
	// Attributes
	//
	
	public function setDefaultFormAttributes () {
		
		if ($this->defaultClasses) {
			$this->addClass ('form');
		}
		
		switch ($this->theme) {
							
			case 'tailwind':
				$classes = config ('laravel-forms.tailwind--classes--form', '');
				$this->addClass ($classes);
				break;
			
		}
	}
	
	
	public function setDefaultFormItemAttributes () {
		
		if ($this->defaultClasses) {
			$this->addClass (['form-item', 'form-item--' . $this->field()->type]);
		}
				
		$this->setConfigurableClasses ('classes--form-item', $this->field()->type);		

	}
	
	
	public function setDefaultLabelContainerAttributes () {
		
		if ($this->defaultClasses) {
			$this->addClass (['label-container', 'label-container--' . $this->field()->type]);
		}
		$this->setConfigurableClasses ('classes--label-container', $this->field()->type);		
		
	}
	
	
	public function setDefaultLabelAttributes () {
		
		if ($this->defaultClasses) {
			$this->addClass (['label', 'label--' . $this->field()->type]);
		}
		$this->setConfigurableClasses ('classes--label', $this->field()->type);		
		
	}
	
	
	public function setDefaultLabelTextAttributes () {
		
		if ($this->defaultClasses) {
			$this->addClass (['label-text', 'label-text--' . $this->field()->type]);
		}
		$this->setConfigurableClasses ('classes--label-text', $this->field()->type);		
		
	}
	
	
	public function setDefaultFieldContainerAttributes () {
		
		if ($this->defaultClasses) {
			$this->addClass (['input-container', 'input-container--' . $this->field()->type]);
		}
		$this->setConfigurableClasses ('classes--field-container', $this->field()->type);
		
	}
	
	
	public function setDefaultFieldAttributes () {
		
		if ($this->defaultClasses) {
			$this->addClass (['input', 'input--' . $this->type]);
		}
		$this->setConfigurableClasses ('classes--field', $this->type);
	
	}	
	
	
	protected function setDefaultErrorMessageContainerAttributes () {
		$this->setConfigurableClasses ('classes--error--message-container', $this->field()->type);
	}
	
	
	protected function setDefaultErrorMessageAttributes () {
		$this->setConfigurableClasses ('classes--error--message', $this->field()->type);		
	}
	
	
	protected function setDefaultErrorIconContainerAttributes () {
		$this->setConfigurableClasses ('classes--error-icon-container', $this->field()->type);	
	}
	
	
	protected function setDefaultErrorIconAttributes () {
		
		$this->addAttribute ('xmlns', 'http://www.w3.org/2000/svg');
		$this->addAttribute ('viewBox', '0 0 20 20');
		$this->addAttribute ('fill', 'currentColor');
		$this->addAttribute ('aria-hidden', 'true');
	
		$this->setConfigurableClasses ('classes--error-icon', $this->field()->type);	

	}
	
	protected function setDefaultColonAttributes () {
		$this->setConfigurableClasses ('classes--colon', $this->field()->type);		
	}
	
	
	protected function setDefaultRequiredAttributes () {
		$this->setConfigurableClasses ('classes--required', $this->field()->type);	
	}
	
	
	protected function setConfigurableClasses ($element, $type) {
		
		if ($this->defaultClasses) {
			$defaultClasses = config ('laravel-forms.' . $element, '');
			$this->addClass ($defaultClasses);
		}
		
		if (!is_string ($this->theme) || $this->theme == '') {
			return;
		}
		
		$config = 'laravel-forms.' . $this->theme . '--' . $element;
		$classes = config ($config, '');

		$this->addClass ($classes);

		$classes = $this->getConfigurableClasses ($config, $type);
		
		if ((is_array ($classes) && count ($classes) > 0) || (is_string ($classes) && trim ($classes) != '')) {
			$this->addClass ($classes);
		}
		
	}
	
	
	protected function removeConfigurableClasses ($element, $type) {
		
		if (!is_string ($this->theme) || $this->theme == '') {
			return;
		}
		
		$config = 'laravel-forms.' . $this->theme . '--' . $element;
		$classes = config ($config, '');
		$this->removeClass ($classes);

		$classes = $this->getConfigurableClasses ($config, $type);
		if ((is_array ($classes) && count ($classes) > 0) || (is_string ($classes) && trim ($classes) != '')) {
			$this->removeClass ($classes);
		}
		
	}
	
	
	protected function getConfigurableClasses ($config, $type) {
		
		switch ($type) {
					
			case 'text':
			case 'email':
			case 'number':
			case 'password':
				$classes = config ($config . '--text', '');
				break;
				
			case 'textarea':
				$classes = config ($config . '--textarea', '');
				break;
				
			case 'select':
				$classes = config ($config . '--select', '');
				break;
				
			case 'checkbox':
				$classes = config ($config . '--checkbox', '');
				break;
				
			case 'radio':
				$classes = config ($config . '--radio', '');
				break;
				
			case 'file':
				$classes = config ($config . '--file', '');
				break;
				
			case 'image':
				$classes = config ($config . '--image', '');
				break;
				
			case 'button':
			case 'submit':
				$classes = config ($config . '--button', '');
				break;
				
			case 'html':
				$classes = config ($config . '--html', '');
				break;
				
			case 'field-group':
			case 'radios':
				$classes = config ($config . '--field-group', '');
				break;

		}
		
		return $classes;
		
	}
	
	
	//
	// Tag Displays
	//		
	
	public function displayElement () {
		$this->display = true;
	}
		
		
	public function dontDisplayElement () {
		$this->display = false;
	}
	
	
	public function display () {
		return $this->display;
	}


	protected function setDefaultFormItemDisplay () {
		
		$default = config ('laravel-forms.display--form-item-tag', 'auto');
		
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
					$this->display = true;
					break;
			
			}
			
		}
	}
	
	
	protected function setDefaultLabelContainerDisplay () {
		
		$default = config ('laravel-forms.display--label-container-tag', 'auto');
		
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
					$this->display = false;
					break;
			
			}
			
		}
	}
	
	
	protected function setDefaultLabelDisplay () {
		
		$default = config ('laravel-forms.display--label-tag', 'auto');
		
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
					$this->display = true;
					break;
			
			}
			
		}
	}
	
	
	protected function setDefaultLabelTextDisplay () {
		
		$default = config ('laravel-forms.display--label-text-tag', 'auto');
		
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
				default:
					$this->display = false;
					if (in_array ($this->field()->type, ['radio', 'checkbox'])) {
						$this->display = true;
					}
					break;
			}
			
		}
	}
	
	
	protected function setDefaultFieldContainerDisplay () {
		
		$default = config ('laravel-forms.display--field-container-tag', 'auto');
		
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
					$this->display = true;
					if (in_array ($this->field()->type, ['radio', 'checkbox'])) {
						$this->display = false;
					}
					break;
			
			}
			
		}
	}
	
	
	protected function setDefaultErrorIconContainerDisplay () {
		
		$default = config ('laravel-forms.display--error-icon-container', 'auto');
		
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
					$this->display = true;
					break;
			
			}
			
		}
	}
	
	
	protected function setDefaultErrorIconDisplay () {
		
		$default = config ('laravel-forms.display--error-icon', 'auto');
		
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
					$this->display = true;
					break;
			
			}
			
		}
	}
	
	
	protected function setDefaultErrorMessageContainerDisplay () {
		
		$default = config ('laravel-forms.display--error-message-container', 'auto');
		
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
					$this->display = false;
					break;
					
				default:
					$this->display = false;
					break;
			
			}
			
		}
		
	}
	
	
	protected function setDefaultColonTagDisplay () {

		$default = config ('laravel-forms.display--colon-tag', 'auto');
		if (is_bool ($default)) {
			$this->colon = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
					$this->display = false;
					break;
					
				default:
					$this->display = false;
					break;
			
			}
			
		}
	
	}
	
	
	protected function setDefaultRequiredDisplay () {
		
		$default = config ('laravel-forms.display--required-tag', 'auto');
		
		if (is_bool ($default)) {
			$this->display = $default;
		}
		else if ($default == 'auto') {
			
			switch ($this->theme) {
			
				case 'tailwind':
					$this->display = true;
					break;
					
				default:
					$this->display = true;
					break;
			
			}
			
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
				$this->setConfigurableClasses ('classes--error--form-item', $this->field()->type);
				$this->removeConfigurableClasses ('remove-classes--error--form-item', $this->field()->type);
				break;
			
			case 'label-container':
				$this->setConfigurableClasses ('classes--error--label-container', $this->field()->type);
				$this->removeConfigurableClasses ('remove-classes--error--label-container', $this->field()->type);
				break;
			
			case 'label':
				$this->setConfigurableClasses ('classes--error--label', $this->field()->type);
				$this->removeConfigurableClasses ('remove-classes--error--label', $this->field()->type);
				break;
				
			case 'field-container':
				$this->setConfigurableClasses ('classes--error--field-container', $this->field()->type);
				$this->removeConfigurableClasses ('remove-classes--error--field-container', $this->field()->type);
				break;
				
			case 'field':
				$this->setConfigurableClasses ('classes--error--field', $this->type);
				$this->removeConfigurableClasses ('remove-classes--error--field', $this->type);
				break;	
				
		}	

		$this->addClass ($classes);

	}
	
	
	public function hasError () {
		return $this->error;
	}
	

	
}