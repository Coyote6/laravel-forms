<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\Form;
use Illuminate\Support\Collection;


trait Render {
	

	protected Collection|false $customVariables = false;
	protected Collection|false $templateVariables = false;

    
    // __toString
    //
    // This method is called when the field is rendered as a string. 
    // It generates the HTML for the field and returns it. This allows you to render the field by simply echoing it or including it in a blade template.
    //
    // @return string
    // @see generateHtml()
    //
	public function __toString () {
		return $this->generateHtml();
	}



	//
	// Component
	//
    // Set and get the component property for this field. This is used to determine which blade template to use when rendering the field.
    // If the component property is not set, it will use the default component for this class.
    //


	// Get Default Component
	//
	// Override this method in your field class to set the default component for that field. 
	// This is used to determine which blade template to use when rendering the field.
	//
	// @return string
	//
    public function getDefaultComponent (): string {
        if (property_exists ($this, 'defaultComponent') && is_string ($this->defaultComponent) && $this->defaultComponent != '') {
            return $this->defaultComponent;
        }
        return 'default';
    }


	// Set Component
	//
	// @param string $component - The name of the component to use for this field. This should correspond to a blade template in the theme's components folder.
	// @return self
	//
    public function setComponent (string $component): self {
        $this->component = $component;
        return $this;
    }


    // Component
    //
    // @alias setComponent
    // @param string $component - The name of the component to use for this field. This should correspond to a blade template in the theme's components folder.
    // @return self
    //
    public function component (string $component): self {
        return $this->setComponent($component);
    }


    // Get Component
    //
    // Get the component for this field. This is used to determine which blade template to use when rendering the field. If the component property is not set, it will use the default component for this class.
    //
    // @return string
    //
    public function getComponent (): string {
        if (property_exists ($this, 'component') && is_string ($this->component) && $this->component != '') {
            return $this->component;
        }
        return self::getDefaultComponent();
    }


    //
    // Theme
    //
    // Get and set the theme for this field. This is used to determine which blade template to use when rendering the field.
    // If the theme property is not set, it will use the default theme from the config.
    //

    public function getDefaultTheme (): string {
        if (property_exists ($this, 'defaultTheme') && is_string ($this->defaultTheme) && $this->defaultTheme != '') {
            return $this->defaultTheme;
        }
        return config('forms.theme', 'flux');
    }

    public function setTheme (string $theme): self {
        $this->theme = $theme;
        return $this;
    }

    public function theme (string $theme): self {
        return $this->setTheme($theme);
    }

    public function getTheme (): string {
        if (property_exists ($this, 'theme') && is_string ($this->theme) && $this->theme != '') {
            return $this->theme;
        }
        return self::getDefaultTheme();
    }


    //
    // Theme Subdirectory/Folder
    //
    // Get and set the theme subdirectory for this field. This is used to determine which blade template to use when rendering the field.
    // If the theme property is not set, it will use the default theme from the config.
    //

    // Get Default Theme Subdirectory
    //
    // Get the default theme directory value. Override this values for fields and components.
    //
    // Dev Note:
    //      Be sure to add the '.' before the name.
    //
    // @return string
    //
    public function getDefaultThemeSubdirectory (): string {
        if (property_exists ($this, 'defaultThemeSubdirectory') && is_string ($this->defaultThemeSubdirectory) && $this->defaultThemeSubdirectory != '') {
            return $this->defaultThemeSubdirectory;
        }
        return '';
    }

    // Set Theme Subdirectory
    //
    // This is the sub-directory for the theme where the components are stored.
    //
    // Dev Note:
    //      Be sure to add the '.' before the name.
    //
    // @param string $directory - The sub directory path to the component inside the theme.
    // @return self
    //
    public function setThemeSubdirectory (string $directory): self {
        $this->themeSubdirectory = $directory;
        return $this;
    }
    

    // Theme Subdirectory
    //
    // @alias setThemeSubdirectory
    // @param string $directory - The sub directory path to the component inside the theme.
    // @return self
    //
    public function themeSubdirectory (string $directory): self {
        return $this->setThemeSubdirectory($directory);
    }

    // Get Theme Subdirectory
    //
    // Retrieve the theme subdirectory first looking for the themeSubdirectory property,
    // if not set, then use the default.
    //
    // @return string
    //
    public function getThemeSubdirectory (): string {
        if (property_exists ($this, 'themeSubdirectory') && is_string ($this->themeSubdirectory) && $this->themeSubdirectory != '') {
            return $this->themeSubdirectory;
        }
        return self::getDefaultThemeSubdirectory();
    }

    
    //
    // Template
    //
    // Get and set the template for this field. This is used to determine which blade template to use when rendering the field.
    // If the template property is not set, it will use the default template for this class.
    //

    public function getDefaultTemplate () {
        return 'forms::' . $this->getTheme() . $this->getThemeSubdirectory() . '.' . $this->getComponent();
    }

    public function setTemplate (string $template): self {
        $this->template = $template;
        return $this;
    }

    public function template (string $template): self {
        return $this->setTemplate($template);
    }

    public function getTemplate (): string {
        if (property_exists($this, 'template') && is_string ($this->template) && $this->template != '') {
            return $this->template;
        }
        return 'forms::' . $this->getTheme() . $this->getThemeSubdirectory() . '.' . $this->getComponent();
    }



    //
    // Template Variables
    //


    // Add Template Variable
    //
    // Adds a single variable to the template variables collection. These variables are passed to the blade template when rendering the field.
    // 
    // @param string $name - The name of the variable to add. This is the name that will be used to access the variable in the blade template.
    // @param mixed $value - The value of the variable to add. This can be any type of data that you want to pass to the blade template.
    // @return self
    //  
    protected function addTemplateVariable (string $name, $value): self {
        if ($this->templateVariables === false) {
            $this->templateVariables = collect();
        }
		$this->templateVariables->put($name, $value);
		return $this;
	}


    // Add Template Variables
    //
    // Adds multiple variables to the template variables collection. These variables are passed to the blade template when rendering the field.
    //
    // @param array|Collection $vars - An associative array or collection of variables to add. The keys of the array should be the names of the variables, and the values should be the values of the variables.
    // @return self
    //
    public function addTemplateVariables (Collection|array $vars):self {
		foreach ($vars as $name => $value) {
			$this->addTemplateVariable ($name, $value);
		}
		return $this;
	}
	

    // Remove Template Variable
    //
    // Removes a single variable from the template variables collection.
    //
    // @param string $name - The name of the variable to remove. This is the name that was used to access the variable in the blade template.
    // @return self
    //
    protected function removeTemplateVariable (string $name): self {
		if ($this->templateVariables && $this->templateVariables->has($name)) {
			$this->templateVariables->forget($name);
		}
		return $this;
	}


    // Remove Template Variables
    //
    // Removes a multiple variable from the template variables collection.
    //
    // @param Collection|array $names - The names of the variables to remove. This is the name that was used to access the variable in the blade template.
    // @return self
    //
    protected function removeTemplateVariables (Collection|array $names): self {
		if ($this->templateVariables) {
			foreach ($names as $name) {
				if ($this->templateVariables->has($name)) {
					$this->templateVariables->forget($name);
				}
			}
		}
		return $this;
	}

    // Template Variables
    //
    // Get the template variables collection. This is used to pass variables to the blade template when rendering the field.
    //
    // @return Collection
    //
	protected function templateVariables (): Collection {
         if ($this->templateVariables === false) {
            $this->templateVariables = collect();
        }
        return $this->templateVariables;
    }



	//
    // Custom Template Variables
    //
	
    // Add Custom Variable
    //
    // Adds a single variable to the custom variables collection. These variables are passed to the blade template when rendering the field, and are intended to be used for variables that are not specific to the field, but are still needed in the template.
    //
    // @param string $name - The name of the variable to add. This is the name that will be used to access the variable in the blade template.
    // @param mixed $value - The value of the variable to add. This can be any type of data that you want to pass to the blade template.
    // @return self
    //
	public function addCustomVariable (string $name, $value): self {
        if ($this->customVariables === false) {
            $this->customVariables = collect();
        }
		$this->customVariables->put($name, $value);
		return $this;
	}
	

    // Add Custom Variables
    //
    // Adds multiple variables to the custom variables collection. These variables are passed to the blade template when rendering the field, and are intended to be used for variables that are not specific to the field, but are still needed in the template.
    //
    // @param Collection|array $vars - An associative array or collection of variables to add to the custom variables collection. The keys of the array should be the names of the variables, and the values should be the values of the variables.
    // @return self
    //
	public function addCustomVariables (Collection|array $vars): self {
		foreach ($vars as $name => $value) {
			$this->addCustomVariable ($name, $value);
		}
		return $this;
	}
	

    // Remove Custom Variable
    //
    // Removes a single variable from the custom variables collection.
    //
    // @param string $name - The name of the variable to remove. This is the name that was used to access the variable in the blade template.
    // @return self
    //
	public function removeCustomVariable (string $name): self {
		if ($this->customVariables && $this->customVariables->has($name)) {
			$this->customVariables->forget($name);
		}
		return $this;
	}


    // Remove Custom Variables
    //
    // Removes multiple variables from the custom variables collection.
    //
    // @param Collection|array $names - The names of the variables to remove. This is the name that was used to access the variable in the blade template.
    // @return self
    //
	public function removeCustomVariables (Collection|array $names): self {
		if ($this->customVariables) {
			foreach ($names as $name) {
				if ($this->customVariables->has($name)) {
					$this->customVariables->forget($name);
				}
			}
		}
		return $this;
	}

    // Custom Variables
    //
    // Get the custom variables collection. This is used to pass variables to the blade template when rendering the field, and are intended to be used for variables that are not specific to the field, but are still needed in the template.
    //
    // @return Collection
	public function customVariables (): Collection {
         if ($this->customVariables === false) {
            $this->customVariables = collect();
        }
        return $this->customVariables;
    }

	

	protected function prerenderField () {}
	
	
	protected function prerender () {}
	

	
	public function generateHtml () {
		/*		
		if (property_exists ($this, 'form') && $this->form instanceof Form) {
			if (!isset ($this->form->renderedFields[$this->name])) {
				$this->form->renderedField ($this->name);
			}
			else {
				return '';
			}
		}
			*/
		
		
		$this->prerenderField();
		$this->prerender();
		$templateVars = $this->templateVariables();

        // Use Union to prevent tampering with the original template variables collection. 
		$vars = $templateVars->union ($this->customVariables());

        // Render the template and return the HTML.
		return view ($this->getTemplate(), $vars->all())->render();
	
	}


	public function render () {
		print $this->generateHtml();
	}


}