<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;

class File extends Input {
	
	protected $allSuffix = 'All';
	protected $removedSuffix = 'Removed';
	protected $previousSuffix = 'PreviousUploads';
	protected $tempSuffix = 'TempAccessTimes';
	
	protected $type = 'file';
	protected $template = 'file';
	protected $multifile = false;
	protected $maxFiles = 0;			// 0 is unlimited
	
	public $showUploader = true;		// Keep public in case someone wants to shut off the uploader conditionally
	public $count = 0;
	public $displayFilename = true;
	
	public string $allModel;
	public string $removedModel;
	public string $previousModel;
	public string $tempAccessModel;
	
	
	//
	// Update the parent constructor to build the property names.
	//
	public function __construct (string $name) {
		parent::__construct ($name);
	}
	
	public function livewireModel (string $name = null) {
		parent::livewireModel ($name);
		$this->allModel = $this->livewireModel . $this->allSuffix;
		$this->removedModel = $this->livewireModel . $this->removedSuffix;
		$this->previousModel = $this->livewireModel . $this->previousSuffix;
		$this->tempAccessModel = $this->livewireModel . $this->tempSuffix;
		return $this;
	}
	
	protected function defaultRules () {
		return ['nullable', 'file'];
	}
	
	
	//
	// Rules
	//

	public function rules () {
		
		if ($this->isLw()) {	
				
			if (isset ($this->rules['required'])) {
				$previouslyUploadedCount = $this->getPreviousUploadsCount();
				if ($previouslyUploadedCount > 0) {
					unset ($this->rules['required']);
					$this->rules['nullable'] = 'nullable';
				}
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
	
	
	public static function getFilenameForUrl (string $filename) {
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
	

	//
	// Check to make sure that the developer set up the livewire component property
	// properly.
	//
	// We have to call this after Livewire processes the uploads so we call it
	// just before we render the field to make sure it is set properly.
	//
	// @return void
	//
	protected function checkLwSetup (): void {
			
		if (!is_object ($this->form->getComponent())) {
			trigger_error ("The '{$this->name}' field is not properly configured. Please be sure to add the Livewire component to the form()/new Form () call as a parameter.  Please see the documentation for further instructions.");
		}
		
		if (!class_exists ('\Livewire\TemporaryUploadedFile')) {
			trigger_error ("The \Livewire\TemporaryUploadedFile class was not found. Please make sure to install Livewire before using as a Livewire enabled form.");
		}
		
		$lw = $this->form->getComponentProperty ($this->livewireModel);

		if (is_null ($lw)) {
			trigger_error ("The '{$this->name}' field is not properly configured. Please make sure the Livewire property '{$this->livewireModel}' is set to null or a '\Livewire\TemporaryUploadedFile' object for single file uploads or to an array for multifile uploads.");
		}
		else if ($this->multifile && !is_array ($lw)) {
			trigger_error ("The '{$this->name}' field is not properly configured. Please make sure the Livewire property '{$this->livewireModel}' is set as an array for multifile uploads.");
		}
		else if (!$this->multifile && !is_null ($lw) && !is_object ($lw)) {
			trigger_error ("The '{$this->name}' field is not properly configured. Please make sure the Livewire property '{$this->livewireModel}' is set to null or is a '\Livewire\TemporaryUploadedFile' object.");	
		}

		
	}
	
	
	protected function initPreviousProperty (): array {
		return $this->setComponentProperty ($this->previousModel, []);
	}
	
	
	protected function initAllProperty (): array {
		return $this->setComponentProperty ($this->allModel, []);
	}
	
	
	protected function initRemovedProperty (): array {
		return $this->setComponentProperty ($this->removedModel, []);
	}
	
	
	protected function initTempAccessProperty (): array {		
		return $this->setComponentProperty ($this->tempAccessModel, []);
	}
	
	
	protected function checkInitPreviousProperty (): void {
		$c = $this->getComponentProperty ($this->previousModel);
		if (is_null ($c)) {
			$this->initPreviousProperty();
		}
	}
	
	
	protected function checkInitAllProperty (): void {
		$c = $this->getComponentProperty ($this->allModel);
		if (is_null ($c)) {
			$this->initAllProperty();
		}
	}
	
	
	protected function checkInitRemovedProperty (): void {
		$c = $this->getComponentProperty ($this->removedModel);
		if (is_null ($c)) {
			$this->initRemovedProperty();
		}
	}
	
	
	protected function checkInitTempAccessProperty (): void {		
		$c = $this->getComponentProperty ($this->tempAccessModel);
		if (is_null ($c)) {
			$this->initTempAccessProperty();
		}
	}
	
	
	protected function checkInitProperties (): void {
		$this->checkInitPreviousProperty();
		$this->checkInitAllProperty();
		$this->checkInitRemovedProperty();
		$this->checkInitTempAccessProperty();
	}
	
	
	//
	// Get all the previously uploaded files to the livewire component property.
	//
	// @return array
	//
	protected function setPreviousUploads (): array {
						
		$previouslyUploaded = $this->initPreviousProperty();
	
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
						'filename' => static::getFilename ($v)
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
					'filename' => static::getFilename ($this->value)
				];	
			}
		}
		
		return $this->setComponentProperty ($this->previousModel, $previouslyUploaded);
		
	}
	
	
	protected function setAllUploads (): array {
		
		$allUploads = $this->initAllProperty();
		$uploaded = $this->getComponentProperty ($this->livewireModel);
		
		// Add all previous uploads.
		foreach ($this->getPreviousUploads() as $hash => $value) {
			$allUploads[$hash] = $value;	
		}
		
		
		//
		// Multifile Upload
		//
		if ($this->isMulti ()) {	
			
			// Add the upload to the all uploads array.
			if (is_array ($uploaded) && count ($uploaded) > 0) {
				foreach ($uploaded as $file) {
// Change hash to md5 of the file?
					$hash = md5 ($file->getFilename());
					if ($file instanceof \Livewire\TemporaryUploadedFile && !isset ($allUploads[$hash])) {
						$allUploads[$hash] = [
							'type' => 'object',
							'model' => false,
							'model-id' => false,
							'upload' => true,
							'value' => $file,
							'preview-url' => $this->getPreviewUrl ($file),
							'filename' => static::getFilename ($file)
						];
					}
				}
			}
		}
		//
		// Single File Upload
		//
		else {
			if ($uploaded && $uploaded instanceof \Livewire\TemporaryUploadedFile) {
// Change hash to md5 of the file?
				$hash = md5 ($uploaded->getFilename());
				if (!isset ($allUploads[$hash])) {
					$allUploads[$hash] = [
						'type' => 'object',
						'model' => false,
						'model-id' => false,
						'upload' => true,
						'value' => $uploaded,
						'preview-url' => $this->getPreviewUrl ($uploaded),
						'filename' => static::getFilename ($uploaded)
					];
				}

			}
				
		}
		
		return $this->setComponentProperty ($this->allModel, $allUploads);
			
	}
	
	

	//
	// Set all removed uploads... this is actually done in the trait
	// WithFileUploads - removeFile() method.
	//
	// @see \Coyote6\LaravelForms\Traits\WithFileUploads
	//
	// @return array
	//
	protected function setRemovedUploads (): array {
		
/*
		// Get the previous list of uploads.
		$previous = $this->getPreviousUploads();

		// Loop through the current uploads and remove any of the previous
		// uploads to leave us with the uploads that are no longer available.
		//
		foreach ($this->getAllUploads() as $hash => $value) {
			if (isset ($previous[$hash])) {
				unset ($previous[$hash]);
			}
		}
		
		return $this->setComponentProperty ($this->removedModel, $previous);
*/
		return $this->setComponentProperty ($this->removedModel, []);
			
	}

	
	
	//
	// Set the access time on a per file hash basis.
	// Give each file a 30 minute viewing window.
	//
	// @return int
	//
	protected function setTempAccessTime ($hash): int {
		
		$accessTime = now()->addMinutes(30);
		
		if ($this->isLw()) {
			$accessTimes = $this->getTempAccessTimes();
			$accessTimes[$hash] = $accessTime;
			$this->setComponentProperty ($this->tempAccessModel, $accessTimes);
		}

		return $accessTime;
		
	}
	
	
	//
	// Get all the previously uploaded files.
	//
	// @return []
	//
	protected function getPreviousUploads (): array {
			
		$previouslyUploaded = [];
		if ($this->isLw()) {
			$previouslyUploaded = $this->getComponentProperty ($this->previousModel);
			if (is_null ($previouslyUploaded)) {
				return $this->setPreviousUploads();
 			}
		}

		return $previouslyUploaded;
		
	}
	
	
	
	//
	// Get the count for all uploaded files on this field.
	//
	// @return int
	//
	public function getPreviousUploadsCount (): int {
		// Use the compenent method so we do not call $this->setPreviousUploads() additional times.
		$prev = $this->getComponentProperty ($this->previousModel);
		if (!is_array ($prev)) {
			return 0;
		}
		return count ($prev);
		
	}

	
	//
	// Get all the previously uploaded files.
	//
	// @return []
	//
	public function getAllUploads (): array {
									
		if ($this->isLw()) {
			$this->setAllUploads();
			return $this->getComponentProperty ($this->allModel);
		}
				
		return [];
		
	}
	
	
	//
	// Get the count for all uploaded files on this field.
	//
	// @return int
	//
	public function getAllUploadsCount (): int {
		// Use the compenent method so we do not call $this->setAllUploads() additional times.
		$allUploads = $this->getComponentProperty ($this->allModel);
		if (!is_array ($allUploads)) {
			return 0;
		}
		return count ($allUploads);
	}
	
	
	//
	// Get all the uploads that were removed.  These are ones that were
	// previously uploaded but were removed by the user.
	//
	// @return array
	//
	protected function getRemovedUploads (): array {

		$removed = [];
		
		if ($this->isLw()) {
			$removed = $this->getComponentProperty ($this->removedModel);
			if (is_null ($removed)) {
				return $this->setRemovedUploads();
			}
		}
		
		return $removed;
		
	}
	
	
	//
	// Get all the access times for the file hash.
	//
	// @return array
	//
	protected function getTempAccessTimes (): array {
		$accessTimes = [];
		if ($this->isLw()) {
			$accessTimes = $this->getComponentProperty ($this->tempAccessModel);
			if (is_null ($accessTimes)) {
				return $this->initTempAccessProperty();
			}
		}
		return $accessTimes;
	}

	
	
	protected static function getHashedKey ($value) {
		
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
	
	
	protected static function getFilename ($value): string {
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
	
	protected static function getLivewireTempFileExt ($value): string|null {
		$ext = $value->getExtension();
		if (is_null ($ext) || $ext == '') {
			$ext = (new \Symfony\Component\Mime\MimeTypes)->getExtensions(\Illuminate\Support\Facades\File::mimeType ($value->path()))[0];
		}
		return $ext;
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
				$ext = static::getLivewireTempFileExt ($value);
				
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
				        	'media.temporary-preview', $accessTimes[$hash], ['style' => $this->previewStyle, 'slug' => static::getFilenameForUrl ($value->getFilename())]
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
	
	
	protected function getPreviews (): false|array {
	
		$preview = false;
		
		if ($this->isLw()) {
			
			$preview = [];		
			foreach ($this->getAllUploads() as $hash => $value) {
				$preview[$hash] = [
					'url' => $value['preview-url'],
					'filename' => $value['filename']
				];
			}
			
			$count = $this->getAllUploadsCount();
			if (!$this->multifile && $count > 0) {
				$this->showUploader = true;
			}
			if ($count == 0) {
				$preview = false;
			}
			
			
			return $preview;	
				
		}
				
//
// Need to figure out what $this->value is on non-lw fields.
// Been too long and don't remember.
//	
		if (!is_null ($this->value)) {
			$preview = [];
			if ($this->isMulti()) {
				foreach ($this->value as $file) {
					$preview[static::getHashedKey ($file)] = [
						'url' => $this->getPreviewUrl ($file),
						'filename' => static::getFilename ($file)
					];
				}
			}
			else {
				$preview[static::getHashedKey ($this->value)] = [
					'url' => $this->getPreviewUrl ($this->value),
					'filename' => static::getFilename ($this->value)
				];
			}
			
		}
		
		return $preview;			
				

	}
	
	
	//
	// File Field Calls
	//
	
	
	//
	// Allow the preview style to be changed if the media library is loaded
	// and the style exists.
	//
	// @return static
	//
	public function previewStyle (string $style): static {
		
		if (!class_exists ('Coyote6\LaravelMedia\Models\ImageStyle')) {
			trigger_error ('You must use the Coyote6\LaravelMedia library to use previewStyle() method.');
		}
		
		if (!\Coyote6\LaravelMedia\Models\ImageStyle::exists ($style)) {
			trigger_error ("No matching image style was found. Please make sure the '{$style}' style for the '{$this->name}' image field has been set in the Coyote6\LaravelMedia package.");
		}
		
		$this->previewStyle = $style;
		return $this;
		
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
		
		$this->addAttribute ('name', $this->livewireModel);
		$this->addAttribute ('type', $this->type);
		
	}
	
	
	protected function templateVariables () {
					
		$vars = parent::templateVariables();
		
		// We rebuild the all uploads array here in the $this->getPreviews() method.
		// 
		// Note:
		// 	$this->getPreviews() must be called before the $this->checkInitProperties()
		//	otherwise the previous uploads array will not be built properly as the value
		//	of the property will be set to an array and never trigger the
		//	$this->setPreviousUploads() method.
		//
		$vars += ['previews' => $this->getPreviews()];
		
		// Make sure our custom properties are initiated in case the were missed in the boot() method.
		$this->checkLwSetup();
		
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
		
		// Make sure all of our file field properties have been initiated
		// so that we have access to them on livewire calls.
		//
		$this->checkInitProperties();

		$vars += [
			'multifile' => $this->multifile,
			'maxFiles' => $this->maxFiles,
			'showUploader' => $this->showUploader,
			'displayFilename' => $this->displayFilename
		];
		
		return $vars;
		
	}
	
	
	
}


