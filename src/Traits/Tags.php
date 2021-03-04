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
	
}