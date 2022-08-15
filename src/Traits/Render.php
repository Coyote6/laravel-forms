<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\Form;


trait Render {
	
	
	public $cache;
	protected $customVariables = [];

	
	public function __toString () {
		return $this->generateHtml();
	}
	
	
	public function addCustomVariable (string $name, $value) {
		$this->customVariables[$name] = $value;
		return $this;
	}
	
	public function addCustomVariables (array $vars) {
		foreach ($vars as $name => $value) {
			$this->addTemplateVariable ($name, $value);
		}
		return $this;
	}
	
	public function removeTemplateVariable (string $name) {
		if (isset ($this->customVariables[$name])) {
			unset ($this->customVariables[$name]);
		}
		return $this;
	}

	
	public function defaultTemplateDir () {
		if (property_exists ($this, 'defaultTemplateDir')) {
			return $this->defaultTemplateDir;
		}
		return 'forms';
	}


	public function template () {
		return $this->template;
	}

	
	protected function prerenderField () {}
	
	
	protected function prerender () {}
	
	
	// @return null or []
	protected function templateVariables () {}
	
	
	public function generateHtml () {
				
		if (property_exists ($this, 'form') && $this->form instanceof Form) {
			if (!isset ($this->form->renderedFields[$this->name])) {
				$this->form->renderedField ($this->name);
			}
			else {
				return '';
			}
		}
		
		
		$this->prerenderField();
		$this->prerender();
		$vars = $this->templateVariables();
		$vars += $this->customVariables;
				
		$cacheKey = 'forms::' . $this->id;
		$doubleCheck = config ('forms.cache--double-check', true);
		if (!is_bool ($doubleCheck)) {
			$doubleCheck = true;
		}

		if (!is_bool ($this->cache)) {
			$this->cache = config ('forms.cache', true);
		}
		
		
		if ($this->cache && cache()->has ($cacheKey)) {
			
			$template = cache()->get ($cacheKey);
			if (!$doubleCheck || view()->exists($template)) {
				return view ($template, $vars)->render();
			}
			
		}
		else if (cache()->has ($cacheKey)) {
			cache()->forget ($cacheKey);
		}
		
		$theme = false;
		if (property_exists ($this, 'theme') && is_string ($this->theme) && $this->theme != '') {
			$theme = $this->theme;
		}
		$template = 'forms.' . $this->template();
		
		if (property_exists ($this, 'id') && view()->exists ($template . '--' . $this->id)) {
			$template .= '--' . $this->id;
		}
		else if (property_exists ($this, 'id') && view()->exists ($this->defaultTemplateDir() . '::' . $template . '--' . $this->id)) {
			$template = $this->defaultTemplateDir() . '::' . $template . '--' . $this->id;
		}
		else if (property_exists ($this, 'name') && view()->exists ($template . '--' . $this->name)) {
			$template .= '--' . $this->name;
		}
		else if ($theme && view()->exists ('forms.' . $theme . '.' . $this->template())) {
			$template = 'forms.' . $theme . '.' . $this->template();
		}
		else if ($theme && view()->exists ($template . '--' . $theme)) {
			$template = $template . '--' . $theme;
		}
		else if ($theme && view()->exists($this->defaultTemplateDir() . '::' . $template . '--' . $theme)) {
			$template = $this->defaultTemplateDir() . '::' . $template . '--' . $theme;
		}
		else if ($theme && view()->exists ($this->defaultTemplateDir() . '::forms.' . $theme . '.' . $this->template())) {
			$template = $this->defaultTemplateDir() . '::forms.' . $theme . '.' . $this->template();
		}
		else if ($theme && view()->exists ( $this->defaultTemplateDir() . '::' . $template . '--' . $theme)) {
			$template =  $this->defaultTemplateDir() .  '::' . $template . '--' . $theme;
		}
		else if (!view()->exists ($template)) {
			if (view()->exists ($this->defaultTemplateDir() . '::' . $template)) {
				$template =  $this->defaultTemplateDir() . '::' . $template;
			}
			else {
				$template = 'forms::' . $template;
			}
		}
		
		if ($this->cache) {
			cache()->put ($cacheKey, $template);
		}
		

		return view ($template, $vars)->render();
	
	}


	public function render () {
		print $this->generateHtml();
	}


}