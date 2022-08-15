<?php


namespace Coyote6\LaravelForms\Traits;


use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads as WithLivewireFileUploads;


trait WithFileUploads {
	
	
	use WithLivewireFileUploads;
	

	
	public function removeFile (string $property, string $filenameHash) {
		

		$prevPropName = $property . 'PreviousUploads';
		$removedPropName = $property . 'Removed';
		$allPropName = $property . 'All';
		
				
		if (is_array ($this->$prevPropName) && isset ($this->$prevPropName[$filenameHash])) {
			if (!isset ($this->$removedPropName[$filenameHash])) {
				$this->$removedPropName[$filenameHash] = $this->$prevPropName[$filenameHash];
			}
			unset ($this->$prevPropName[$filenameHash]);
		}

		if (is_array ($this->$allPropName) && isset ($this->$allPropName[$filenameHash])) {
			if (!isset ($this->$removedPropName[$filenameHash])) {
				$this->$removedPropName[$filenameHash] = $this->$allPropName[$filenameHash];
			}
			unset ($this->$allPropName[$filenameHash]);
		}

		if (is_array ($this->$property)) {
			foreach ($this->$property as $key => $prop) {
				if ($filenameHash == md5($prop->getFilename())) {
					unset ($this->$property[$key]);
					break;
				}
			}
		}
		else {
			$this->$property = null;
		}

	}
	
	
	public function isTempFile ($file) {
		if ($file instanceof TemporaryUploadedFile) {
			return true;
		}
		return false;
	}
	
	
/*
	protected function resetPropertyValue (string $property) {
		
		$tempPropName = $property . 'Temp';

		
		$previouslyUploaded = $this->$tempPropName;
		$newValue = [];
		
		if (is_array ($previouslyUploaded)) {
			foreach ($previouslyUploaded as $hash => $value) {
				
				// Reuse the object if it is already created.
				// Otherwise, rebuild it, or set the value for
				// non-objects.
				//
				if (is_object ($value['value'])) {
					$newValue[$hash] = $value['value'];
				}
				else {
					if ($value['type'] == 'object' && $value['model']) {
						$model = $value['model'];
						$newValue[$hash] = $model::find($value['model-id']);		
					}
					else if (
						($value['type'] == 'object' && $value['upload']) ||
						$value['type'] == 'string' || 
						$value['type'] == 'integer' || $value['type'] == 'double' || $value['type'] == 'float'
					) {
						$newValue[$hash] = $value['value'];
					}
				}
			}
		}
		
		$this->$property = $newValue;
			
	}
*/
	
    
}
