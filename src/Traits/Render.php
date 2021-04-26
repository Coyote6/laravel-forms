<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\Form;


trait Render {
	
	
	public $cache;

	
	public function __toString () {
		return $this->generateHtml();
	}


	public function template () {
		return $this->template;
	}

	
	protected function prerenderField () {}
	
	
	protected function prerender () {}
	
	
	// @return null or []
	protected function templateVariables () {}
	
	
	public function generateHtml () {
		
		$this->prerenderField();
		$this->prerender();
		$vars = $this->templateVariables();
		$cacheKey = 'laravel-forms::' . $this->id;
		$doubleCheck = config ('laravel-forms.cache--double-check', true);
		if (!is_bool ($doubleCheck)) {
			$doubleCheck = true;
		}

		if (!is_bool ($this->cache)) {
			$this->cache = config ('laravel-forms.cache', true);
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
		else if (property_exists ($this, 'name') && view()->exists ($template . '--' . $this->name)) {
			$template .= '--' . $this->name;
		}
		else if ($theme && view()->exists ('forms.' . $theme . '.' . $this->template())) {
			$template = 'forms.' . $theme . '.' . $this->template();
		}
		else if ($theme && view()->exists ($template . '--' . $theme)) {
			$template = $template . '--' . $theme;
		}
		else if ($theme && view()->exists ('laravel-forms::forms.' . $theme . '.' . $this->template())) {
			$template = 'laravel-forms::forms.' . $theme . '.' . $this->template();
		}
		else if ($theme && view()->exists ('laravel-forms::' . $template . '--' . $theme)) {
			$template = 'laravel-forms::' . $template . '--' . $theme;
		}
		else if (!view()->exists ($template)) {
			$template = 'laravel-forms::' . $template;
		}

		if ($this->cache) {
			cache()->put ($cacheKey, $template);
		}

		return view ($template, $vars)->render();
	
	}


	public function render () {
		if (property_exists ($this, 'form') && $this->form instanceof Form) {
			if (!isset ($this->form->renderedFields[$this->name])) {
				$this->form->renderedField ($this->name);
				print $this->generateHtml();
			}
		}
		else {
			print $this->generateHtml();
		}
	}


}