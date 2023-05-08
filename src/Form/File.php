<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;

class File extends input {
	
	
	protected $type = 'file';
	protected $template = 'file';
	protected $multifile = false;
	protected $maxFiles = 0;			// 0 is unlimited
	
	public $showUploader = true;		// Keep public in case someone wants to shut off the uploader conditionally
	public $count = 0;
	public $displayFilename = true;
	
	
	protected function defaultRules () {
		return ['nullable', 'file'];
	}
	
	//
	// Rules
	//

	public function rules () {

		if ($this->isLw() && isset ($this->rules['required'])) {
			$previouslyUploadedCount = $this->getPreviousUploadsCount();
			if ($previouslyUploadedCount > 0) {
				unset ($this->rules['required']);
				$this->rules['nullable'] = 'nullable';
			}
		}


		return $this->rules;
	
	}
	
	
#
# To Do
#
# Add rule to count the number of files.
#

	// Display file names
	public function displayFilename() {
		$this->displayFilename = true;
	}
	
	public function hideFilename() {
		$this->displayFilename = false;
	}
	
	
	public function isImage ($highDef = true) {
		if ($highDef) {
			$this->rules['mimes'] = 'mimes:jpg,jpeg,gif,png,bmp,svg,webp,heic';
			$this->addAttribute('accept', '.jpg,.jpeg,.gif,.png,.bmp,.svg,.webp,.heic');
			if (isset ($this->rules['image'])) {
				unset ($this->rules['image']);
			}
		}
		else {
			$this->rules['image'] = 'image';
			$this->addAttribute('accept', '.jpg,.jpeg,.gif,.png,.bmp,.svg,.webp');
			if (isset ($this->rules['mimes'])) {
				unset ($this->rules['mimes']);
			}
		}
		return $this;
	}
	
	
	public function getFilenameForUrl (string $filename) {
		if (config ('media.remove_file_ext', true)) {
			$pos = strrpos ($filename, '.');
			if ($pos !== false) {
		        $filename = substr_replace ($filename, '/' , $pos, 1);
		    }
		}
		return $filename;
	}

	
	
	//
	// Livewire Helpers
	//
	public function getPreviousUploadsCount () {
		$previouslyUploaded = $this->getComponentProperty ($this->livewireModel . 'PreviousUploads');
		if (!is_array ($previouslyUploaded)) {
			return 0;
		}
		return count ($previouslyUploaded);
	}
	
	
	public function getAllUploadsCount () {
		$allUploads = $this->getComponentProperty ($this->livewireModel . 'All');
		if (!is_array ($allUploads)) {
			return 0;
		}
		return count ($allUploads);
	}
				
	
	public function getPreviousUploads () {
			
		$previouslyUploaded = [];

		if ($this->isLw()) {

			$previouslyUploaded = $this->getComponentProperty ($this->livewireModel . 'PreviousUploads');

			if (is_null ($previouslyUploaded)) {
				
				$previouslyUploaded = $this->setComponentProperty ($this->livewireModel . 'PreviousUploads', []);

				if ($this->isMulti ()) {
				
					if (is_array ($this->value)) {
						foreach ($this->value as $k => $v) {
							$hash = $this->getHashedKey ($v);
							$previouslyUploaded[$hash] = [
								'type' => gettype ($v),
								'model' => ($v instanceof \Illuminate\Database\Eloquent\Model) ? get_class ($v) : false,
								'model-id' => ($v instanceof \Illuminate\Database\Eloquent\Model) ? $v->getKey() : false,
								'upload' => (class_exists ('\Livewire\TemporaryUploadedFile') && $v instanceof \Livewire\TemporaryUploadedFile),
								'value' => $v,
								'preview-url' => $this->getPreviewUrl ($v),
								'filename' => $this->getFilename ($v)
							];	
						}
					}

				}
				else {
					if (!is_null ($this->value)) {
						$hash = $this->getHashedKey ($this->value);
						$previouslyUploaded[$hash] = [
							'type' => gettype ($this->value),
							'model' => ($this->value instanceof \Illuminate\Database\Eloquent\Model) ? get_class ($this->value) : false,
							'model-id' => ($this->value instanceof \Illuminate\Database\Eloquent\Model) ? $this->value->getKey() : false,
							'upload' => (class_exists ('\Livewire\TemporaryUploadedFile') && $this->value instanceof \Livewire\TemporaryUploadedFile),
							'value' => $this->value,
							'preview-url' => $this->getPreviewUrl ($this->value),
							'filename' => $this->getFilename ($this->value)
						];	
					}
#					else {
#						$previouslyUploaded[1] = null;
#					}
				}
				
				$this->setComponentProperty ($this->livewireModel . 'PreviousUploads', $previouslyUploaded);
					
 			}
#			else if (!$this->isMulti() && is_array ($previouslyUploaded) && count ($previouslyUploaded) == 0) {
#				$previouslyUploaded[1] = null;
#			}
			
		}

		return  $previouslyUploaded;
		
	}
	
	
	public function getRemovedUploads () {
			
		$removedUploads = [];
		
		if ($this->isLw()) {
			$removedUploads = $this->getComponentProperty ($this->livewireModel . 'Removed');
			if (is_null ($removedUploads)) {
				$removedUploads = $this->setComponentProperty ($this->livewireModel . 'Removed', []);
#					$this->setComponentProperty ($this->livewireModel . 'Removed', $removedUploads);
			}
		}
		
		return $removedUploads;
		
	}
	
	
	public function getAllUploads () {
			
		$allUploads =[];
		
		if ($this->isLw()) {

			$allUploads = $this->getComponentProperty ($this->livewireModel . 'All');
			$uploaded = $this->getComponentProperty ($this->livewireModel);

			if (is_null ($allUploads)) {

				$previouslyUploaded = $this->getPreviousUploads();
				$allUploads = $this->setComponentProperty ($this->livewireModel . 'All', []);

				if ($this->isMulti ()) {
					foreach ($previouslyUploaded as $hash => $value) {
						$allUploads[$hash] = $value;	
					}
					if ($uploaded) {
						foreach ($uploaded as $img) {
							if ($img instanceof \Livewire\TemporaryUploadedFile && !isset ($allUploads[md5($img->getFilename())])) {
								$allUploads[md5($img->getFilename())] = [
									'type' => 'object',
									'model' => false,
									'model-id' => false,
									'upload' => true,
									'value' => $img,
									'preview-url' => $this->getPreviewUrl ($img),
									'filename' => $this->getFilename ($img)
								];
							}
						}
					}
				}
				else {
					if ($uploaded) {
						$allUploads[md5($uploaded->getFilename())] = [
							'type' => 'object',
							'model' => false,
							'model-id' => false,
							'upload' => true,
							'value' => $uploaded,
							'preview-url' => $this->getPreviewUrl ($uploaded),
							'filename' => $this->getFilename ($uploaded)
						];
					}
					else if ($previouslyUploaded) {
						foreach ($previouslyUploaded as $hash => $value) {
							$allUploads[$hash] = $value;	
						}
					}
					
#					else {
#						$previouslyUploaded[1] = null;
#					}
				}
				
			}
			else {
				if ($uploaded) {
					if ($this->isMulti() && is_array ($uploaded)) {
						foreach ($uploaded as $img) {
							$hashedName = md5 ($img->getFilename());
							if ($img instanceof \Livewire\TemporaryUploadedFile && !isset ($allUploads[$hashedName])) {
								$allUploads[$hashedName] = [
									'type' => 'object',
									'model' => false,
									'model-id' => false,
									'upload' => true,
									'value' => $img,
									'preview-url' => $this->getPreviewUrl ($img),
									'filename' => $this->getFilename ($img)
								];
							}
						}
					}
					else if ($uploaded instanceof \Livewire\TemporaryUploadedFile) {
						$hashedName = md5 ($uploaded->getFilename());
						if (!isset ($allUploads[$hashedName])) {
							$allUploads[$hashedName] = [
								'type' => 'object',
								'model' => false,
								'model-id' => false,
								'upload' => true,
								'value' => $uploaded,
								'preview-url' => $this->getPreviewUrl ($uploaded),
								'filename' => $this->getFilename ($uploaded)
							];
						}
					}
				}

			}
			
			$allUploads = $this->setComponentProperty ($this->livewireModel . 'All', $allUploads);
#			else if (!$this->isMulti() && is_array ($previouslyUploaded) && count ($previouslyUploaded) == 0) {
#				$previouslyUploaded[1] = null;
#			}
			
		}
		
		return  $allUploads;
		
	}

	
	
	public function getHashedKey ($value) {
		
		if (is_object ($value) && $value instanceof \Illuminate\Database\Eloquent\Model) {
			return md5 ($value->getKey());
		}
		else if (is_object ($value) && class_exists ('\Livewire\TemporaryUploadedFile') && $value instanceof \Livewire\TemporaryUploadedFile) {
			return md5 ($value->getFilename());
		}
		else if (!is_null ($value)) {
			return md5 ($value);
		}
		return 1;
			
	}
	
	
	public function previewStyle (string $style) {
		if (!class_exists ('Coyote6\LaravelMedia\Models\ImageStyle')) {
			trigger_error ('You must use the Coyote6\LaravelMedia library to use previewStyle() method.');
		}
		if (!\Coyote6\LaravelMedia\Models\ImageStyle::exists ($style)) {
			trigger_error ('No matching image style was found. Please make sure the "' . $style . '" style for the "' . $this->name . '" image field has been set in the Coyote6\LaravelMedia package.');
		}
		$this->previewStyle = $style;
		return $this;
	}
	
	
	public function getTempAccessTimes () {
		
		$accessTimes = [];
		
		if ($this->isLw()) {
			$accessTimes = $this->getComponentProperty ($this->livewireModel . 'TempAccessTimes');
			if (is_null ($accessTimes)) {
				$accessTimes = $this->setComponentProperty ($this->livewireModel . 'TempAccessTimes', []);
			}
		}
		
		return $accessTimes;
	}
	
	
	public function setTempAccessTime ($hash) {
		
		$accessTime = now()->addMinutes(30);
		
		if ($this->isLw()) {
			$accessTimes = $this->getTempAccessTimes();
			$accessTimes[$hash] = $accessTime;
			$this->setComponentProperty ($this->livewireModel . 'TempAccessTimes', $accessTimes);
		}

		return $accessTime;
		
	}
	
	
	protected function getPreviewUrl ($value) {
		
		$accessTimes = $this->getTempAccessTimes();
#
# To Do:
#
# Change to icons
#`

		if (is_object ($value)) {
			if (class_exists ('\Livewire\TemporaryUploadedFile') && $value instanceof \Livewire\TemporaryUploadedFile) {
					
				// Get the extension, and if not found,
				// attempt to pull it from the file name.	
				//
				$ext = $value->getExtension();
				if ($ext == '') {
					$ext = (new \Symfony\Component\Mime\MimeTypes)->getExtensions(\Illuminate\Support\Facades\File::mimeType ($value->path()))[0];
				}
				
				//
				// Check to make sure the file type is in the allowable preview image types.
				//
				$allowed = config('livewire.temporary_file_upload.preview_mimes');
				if (in_array ($ext, $allowed)) {
					if (class_exists ('Coyote6\LaravelMedia\Models\Image')) {
												
						$hash = md5 ($value->getFilename());
						if (!isset ($accessTimes[$hash])) {
							$accessTimes[$hash] = $this->setTempAccessTime($hash);
						}
						
						return URL::temporarySignedRoute(
				        	'media.temporary-preview', $accessTimes[$hash], ['style' => $this->previewStyle, 'slug' => $this->getFilenameForUrl ($value->getFilename())]
				        );
					}
										
					return $value->temporaryUrl();
				}
				
				//
				// Use stock images for default
				//

				if ($ext == 'pdf') {
					return 'https://cdn.iconscout.com/icon/free/png-256/free-pdf-file-2951641-2446711.png?f=webp&w=256';
				}

				return 'https://cdn.iconscout.com/icon/free/png-256/free-document-1439233-1214243.png?f=webp&w=256';
				
			}
			else if (class_exists ('Coyote6\LaravelMedia\Models\Image') && $value instanceof \Coyote6\LaravelMedia\Models\Image) {
				if (class_exists ('Coyote6\LaravelMedia\Models\Image') && \Coyote6\LaravelMedia\Models\ImageStyle::exists ($this->previewStyle)) {
					return $value->imageStyleUrl ($this->previewStyle);
				}
				else {
					return $value->url();
				}
			}
			else if (class_exists ('Coyote6\LaravelMedia\Concerns\Url') && $value instanceof \Coyote6\LaravelMedia\Concerns\Url) {
				if (class_exists ('Coyote6\LaravelMedia\Models\Image') && \Coyote6\LaravelMedia\Models\ImageStyle::exists ($this->previewStyle)) {
					return $value->imageStyleUrl ($this->previewStyle);
				}
				else {
					return $value->url();
				}
			}
		}
		else if (is_string ($value) && $value != '') {
			return $value;
		}
			
	}
	
	
	protected function getFilename ($value) {
		if (is_object ($value)) {
			if (class_exists ('\Livewire\TemporaryUploadedFile') && $value instanceof \Livewire\TemporaryUploadedFile) {
				return $value->getClientOriginalName();
			}
			else if (
				(class_exists ('Coyote6\LaravelMedia\Models\Image') && $value instanceof \Coyote6\LaravelMedia\Models\Image) ||
				(class_exists ('Coyote6\LaravelMedia\Models\File') && $value instanceof \Coyote6\LaravelMedia\Models\File) 
			) {
				return $value->filename;
			}
		}
		else if (is_string ($value)) {
			return $value;
		}
		return 'Unknown File Name';		
	}
	
	
	protected function getPreview () {
	
		$preview = false;
		
		if ($this->isLw()) {
			
			
			if (!is_object ($this->form->getComponent())) {
				trigger_error ('This field is not properly configured.  Please be sure to add the Livewire component to the form()/new Form () call as a parameter.  Please see the documentation for further instructions.');
			}
			
			if (!class_exists ('\Livewire\TemporaryUploadedFile')) {
				trigger_error ('The \Livewire\TemporaryUploadedFile class was not found. Please make sure to install Livewire before using as a Livewire enabled form.');
			}
			
			
			$uploaded = $this->form->getComponentProperty ($this->livewireModel);
			
			if ($this->multifile && !is_array ($uploaded)) {
				trigger_error('This field is not properly configured.  Please make sure the Livewire property \'' . $this->livewireModel . '\' is set as an array for multifile uploads.');
			}
			else if (!$this->multifile && !is_null ($uploaded) && !is_object ($uploaded)) {
				trigger_error('This field is not properly configured.  Please make sure the Livewire property \'' . $this->livewireModel . '\' is set to null or is a Livewire temp upload.');	}
				
			// Initiate all properties for later use.
			$r = $this->getRemovedUploads();
			$d = $this->getPreviousUploads();
			$allUploads = $this->getAllUploads();
				
			foreach ($allUploads as $hash => $value) {
				$preview[$hash] = [
					'url' => $value['preview-url'],
					'filename' => $value['filename']
				];
			}
						
			if (!$this->multifile && $this->getAllUploadsCount() > 0) {
				$this->showUploader = true;
			}
			
			return $preview;	
				
		}
				
		
		if (!is_null ($this->value)) {
			return $previewUrl[$this->getHashedKey($this->value)] = [
				'url' => $this->getPreviewUrl ($this->value),
				'filename' => $this->getFilename ($this->value)
			];
		}			
				

	}
	
/*
	
	public function resetValue () {
		
		$previouslyUploaded = $this->getComponentProperty ($this->livewireModel . 'Temp');
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
		
		if ($this->multifile) {
			$this->setComponentProperty ($this->livewireModel, $newValue);
		}
		else if (isset ($newValue[1])) {
			$this->setComponentProperty ($this->livewireModel, $newValue[1]);
		}
		else {
			$this->setComponentProperty ($this->livewireModel, $newValue);
		}
			
	}
*/
				
	
	
	//
	// Multifile
	//
	
	public function multiple (int $maxFiles = 0) {
		$this->addAttribute('multiple');
		$this->multifile = true;
		
		if ($maxFiles > 0) {
			$this->maxFiles = $maxFiles;
		}
		
		return $this;
	}
	
	
	public function multi (int $maxFiles = 0) {
		return $this->multiple ($maxFiles);
	}
	
	public function isMultifile () {
		if ($this->multifile) {
			return true;
		}
		return false;
	}
	
	public function isMulti () {
		return $this->isMultifile();
	}
	
	
	//
	// Mimes
	//
	
	public function allowedMimes ($mimes = null) {
		$allowed = false;
		if (is_array ($mimes)) {
			foreach ($mimes as &$mime) {
				if (is_string ($mime) && $mime != '') {
					$mime = trim ($mime);
				}
				else {
					unset ($mime);
				}
			}
			$allowed = implode(',', $mimes);
		}
		else if (is_string ($mimes)) {
			$allowed = $mimes;
		}
		if ($allowed) {
			$this->rules['mimes'] = $mimes;
			$split = explode(',',$mimes);
			foreach ($split as &$mime) {
				$mime = '.' . $mime;
			}
			$mimes = implode(',', $split);
			$this->addAttribute('accept', $mimes);
		}
		return $this;
	} 
	
	
	//
	// Form Methods
	//
	
	
	protected function prerender () {
		
//		if ($this->multifile) {
//			$this->addAttribute ('name', $this->name . '[]');
//		}
//		else {
			$this->addAttribute ('name', $this->name);
//		}
		
		$this->addAttribute ('type', $this->type);
		
	}
	
	
	protected function templateVariables () {
			
		$vars = parent::templateVariables();
		$vars += ['previewUrl' => $this->getPreview()];
		
		$count = $this->getAllUploadsCount();
		
		if ($this->multifile) {
			if ($this->maxFiles > 0 && $count >= $this->maxFiles) {
				$this->showUploader = false;
			}
		}
		else {
			if ($count > 0) {
				$this->showUploader = false;
			}
		}
		
		// Remove and rerender the attributes if there are
		// values already uploaded.
		//
		if ($count > 0 && $this->isRequired()) {
			$this->removeAttribute ('required');
			$vars['attributes'] = $this->renderAttributes();
		}
		
		$vars += [
			'multifile' => $this->multifile,
			'maxFiles' => $this->maxFiles,
			'showUploader' => $this->showUploader,
			'displayFilename' => $this->displayFilename
		];
		
		return $vars;
		
	}
	
	
	
}


