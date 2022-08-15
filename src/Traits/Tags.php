<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\FieldItem;


trait Tags {
	
	protected $formItemTag;
	protected $labelContainerTag;
	protected $labelTag;
	protected $labelTextTag;
	protected $fieldContainerTag;
	protected $errorMessageContainerTag;
	protected $errorMessageTag;
	protected $errorIconContainerTag;
	protected $errorIconTag;
	protected $requiredTag;
	protected $colonTag;

	protected function initTags () {
		
		$this->formItemTag = new FieldItem ($this, 'form-item');
		$this->labelContainerTag = new FieldItem ($this, 'label-container');
		$this->labelTag = new FieldItem ($this, 'label');
		$this->labelTextTag = new FieldItem ($this, 'label-text');
		$this->fieldContainerTag = new FieldItem ($this, 'field-container');
		$this->errorMessageContainerTag = new FieldItem ($this, 'error-message-container');
		$this->errorMessageTag = new FieldItem ($this, 'error-message');
		$this->errorIconContainerTag = new FieldItem ($this, 'error-icon-container');
		$this->errorIconTag = new FieldItem ($this, 'error-icon'); 
		$this->requiredTag = new FieldItem ($this, 'required-tag'); 
		$this->colonTag = new FieldItem ($this, 'colon');
		
	}
	
	protected function initTagThemes () {
		
		// Set the theme
		$this->formItemTag->theme = $this->theme;
		$this->labelContainerTag->theme = $this->theme;
		$this->labelTag->theme = $this->theme;
		$this->labelTextTag->theme = $this->theme;
		$this->fieldContainerTag->theme = $this->theme;
		$this->errorMessageContainerTag->theme = $this->theme;
		$this->errorMessageTag->theme = $this->theme;
		$this->errorIconContainerTag->theme = $this->theme;
		$this->errorIconTag->theme = $this->theme; 
		$this->requiredTag->theme = $this->theme; 
		$this->colonTag->theme = $this->theme;
		
		// Init the tags
		$this->formItemTag->init();
		$this->labelContainerTag->init();
		$this->labelTag->init();
		$this->labelTextTag->init();
		$this->fieldContainerTag->init();
		$this->errorMessageContainerTag->init();
		$this->errorMessageTag->init();
		$this->errorIconContainerTag->init();
		$this->errorIconTag->init(); 
		$this->requiredTag->init(); 
		$this->colonTag->init();
		
	}
	
}