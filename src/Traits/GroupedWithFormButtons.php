<?php
	
	
namespace Coyote6\LaravelForms\Traits;



trait GroupedWithFormButtons {
	
	
	protected $groupWithButtons = false;
	

	public function groupWithButtons () {
		$this->groupWithButtons = true;
		return $this;
	}
	
	public function isGroupedWithButtons () {
		return $this->groupWithButtons;
	}
	
}