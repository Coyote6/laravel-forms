<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Text;


class Date extends Text {
	
	protected $type = 'date';
	protected $template = 'date';
	protected $format = 'Y-MM-DD';
	protected $formatType = 'php';

	protected function defaultRules() {
		return ['nullable', 'string', 'date'];
	}
	
	protected function prerender () {
		parent::prerender();
		$this->addAttribute ('type', 'text');
	}
	
	protected function templateVariables () {
		$vars = parent::templateVariables();
		$vars += ['format' => $this->convertJs ($this->format)];
		return $vars;
	}
	
	protected function convertJs () {
		if ($this->formatType == 'php') {
			switch ($this->format) {
				case 'Y-m-d':
					return 'Y-MM-DD';
				case 'Y-m-d H:i:s';
					return 'Y-MM-DD hh:mm:ss';
			}
		}
		return $this->format;
	
	}
	
	protected function phpFormat ($format) {
		$this->format = $format;
		$this->formatType = 'php';
	}
	
	protected function format ($format, $jsFormat = null) {
		
	}
	
	protected function jsFormat ($format) {
		$this->format = $format;
		$this->formatType = 'php';
	}
	
}


