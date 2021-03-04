<?php
	
	
namespace Coyote6\LaravelForms\Traits;



trait Render {
	
	public function __toString() {
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
		$template = 'forms.' . $this->template();
		if (!view()->exists ($template)) {
      $template = 'laravel-forms::' . $template;
    }
		return view ($template, $vars)->render();
	
	}
		
	public function render () {
		print $this->generateHtml();
	}
	

}