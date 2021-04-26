<?php
	
	
namespace Coyote6\LaravelForms\Traits;


trait Weighted {
	
	protected $weight = 0;

	public function weight ($weight) {
		if (is_numeric($weight)) {
			$this->weight = $weight;
		}
		return $this;
	}
	
}