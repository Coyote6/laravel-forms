<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;


class Html extends Field {
	
	protected $type = 'html';
	protected $template = 'html';
		
	public function generateHtml () {
		$vars = [
			'content' => $this->value,
			'attributes' => $this->renderAttributes(),
			'id' => $this->name,
			'name' => $this->name,
			'type' => $this->type
		];
		
		$template = 'forms.' . $this->template;
		if (!view()->exists ($template)) {
      $template = 'laravel-forms::' . $template;
    }
		return view ($template, $vars);
	}
}


