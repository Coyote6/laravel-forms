<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Illuminate\Support\Collection;
use Illuminate\View\ComponentAttributeBag;


trait Attributes {
	
	// Set the properties for attributes and classes. These will be used to store any attributes or classes that are added to the field.
	protected Collection|false $attributes = false;
	protected Collection|false $classes = false;
	
	
	//
	// Generic Attributes
	//
	

	// Check Initialized Attributes
	//
	// This method checks if the $attributes property has been initialized as a collection. If it has not, it initializes it. 
	// This is used to ensure that the $attributes property is always a collection when it is used.
	//
	protected function checkInitializedAttributes (): void {
		if ($this->attributes === false) {
			$this->attributes = collect();
		}
	}
	

	// Set Attribute
	//
	// Sets an attribute for the field. This can be used to set any HTML attribute.
	//
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	// @param string|int|float|bool $value The value of the attribute.
	//
	// @return self
	//
	public function setAttribute (string $name, $value = true): self {
		$this->checkInitializedAttributes();
		if (is_string ($value) || is_numeric ($value) || is_bool ($value)) {
			$this->attributes->put($name, $value);
		}
		return $this;
	}


	// Set Attr
	//
	// @alias setAttribute
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	// @param string|int|float|bool $value The value of the attribute.
	//
	// @return self
	//
	public function setAttr (string $name, $value = true): self {
		return $this->setAttribute ($name, $value);
	}


	// Add Attribute
	//
	// @alias setAttribute
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	// @param string|int|float|bool $value The value of the attribute.
	//
	// @return self
	//
	public function addAttribute (string $name, $value = true): self {
		return $this->setAttribute ($name, $value);
	}
	

	// Add Attr
	//
	// @alias setAttribute
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	// @param string|int|float|bool $value The value of the attribute.
	//
	// @return self
	//
	public function addAttr (string $name, $value = true): self {
		return $this->setAttribute ($name, $value);
	}
	

	// Attribute
	//
	// @alias setAttribute
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	// @param string|int|float|bool $value The value of the attribute.
	//
	// @return self
	//
	public function attribute (string $name, $value = true): self {
		return $this->setAttribute ($name, $value);
	}
	

	// Attr
	//
	// @alias setAttribute
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	// @param string|int|float|bool $value The value of the attribute.
	//
	// @return self
	//
	public function attr (string $name, $value = true): self {
		return $this->setAttribute ($name, $value);
	}
	
	
	// Get Attribute
	//
	// Gets an attribute for the field. This can be used to get any HTML attribute that has been set.
	//
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	//
	// @return string|int|float|bool|null
	//
	public function getAttribute (string $name): string|int|float|bool|null {
		$this->checkInitializedAttributes();
		return $this->attributes->get($name);
	}
	

	// Get Attr
	//
	// @alias getAttribute
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	//
	// @return string|int|float|bool|null
	//
	public function getAttr (string $name): string|int|float|bool|null {
		return $this->getAttribute ($name);
	}	
	
	
	// Has Attribute
	//
	// Checks if an attribute has been set for the field.
	//
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	//
	// @return bool
	//
	public function hasAttribute (string $name): bool {
		$this->checkInitializedAttributes();
		return $this->attributes->has ($name);
	}
	
	
	// Remove Attribute
	//
	// Removes an attribute for the field. This can be used to remove any HTML attribute that has been set.
	//
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	//
	// @return self
	//
	public function removeAttribute (string $name): self {
		$this->checkInitializedAttributes();
		$this->attributes->forget ($name);
		return $this;
	}
	

	// Remove Attr
	//
	// @alias removeAttribute
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	//
	// @return self
	//
	public function removeAttr (string $name): self {
		return $this->removeAttribute ($name);
	}
	
	
	//
	// Classes
	//

	// Check Initialized Classes
	//
	// This method checks if the $classes property has been initialized as a collection. If it has not, it initializes it. 
	// This is used to ensure that the $classes property is always a collection when it is used.
	//
	protected function checkInitializedClasses (): void {
		if ($this->classes === false) {
			$this->classes = collect();
		}
	}
	

	// Add Class
	//
	// Adds a class or classes to the field. This can be used to add any CSS class to the field.
	//
	// @param Collection|array|string $classes The class or classes to add. This can be a string of space-separated classes, 
	// 											an array of classes, or a collection of classes.
	//
	// @return self
	//
	public function addClass (Collection|array|string $classes): self {

		$this->checkInitializedClasses();
		
		// If $classes is a collection, merge it with the existing classes collection.
		if ($classes instanceof Collection) {
			$this->classes = $this->classes->union ($classes);
			return $this;
		}

		// If the $classes parameter is an array, add each class to the classes collection.
		if (is_array ($classes)) {
			foreach ($classes as $class) {
				$this->classes->put ($class, $class);
			}
			return $this;
		}

		// If it's a string, split it by spaces and add each class to the classes collection.
		if (is_string ($classes)) {
			$classStrs = explode (' ', $classes);
			foreach ($classStrs as $class) {
				$class = trim ($class);
				if ($class != '') {
					$this->classes->put ($class, $class);
				}
			}
		}

		return $this;
	}


	// Has Class
	//
	// Checks if a class has been set for the field.
	//
	// Dev Note: 
	//		This method only check for class names set via the setAttribute() method or its alias.
	//		It does not check for classes that may be set in the blade template or by the theme. 
	//		This is because those classes are not stored in the $classes property and are not accessible to this method.
	//
	//
	// @param string $name The name of the attribute (e.g. 'placeholder', 'data-*', etc.)
	//
	// @return bool
	//
	public function hasClass (string $class): bool {
		$this->checkInitializedClasses();
		return $this->classes->has ($class);
	}
	
	
	
	public function removeClass (Collection|array|string $classes): self {
		$this->checkInitializedClasses();
		$this->classes->forget($classes);
		return $this;

	}
	
	public function resetClasses () {
		$this->classes = collect();
		return $this;
	}
	
	

	
	//
	// Rendering Methods
	//

	// Join Attrs
	//
	// This method joins the attributes.
	//
	protected function joinAttributes (): Collection {
		
		$this->checkInitializedAttributes();
		$this->checkInitializedClasses();

		// If the 'class' attribute exists in the attributes array, and the 'attributes--merge-attr-classes' config is true,
		// add them to the $classes property, and remove any existing 'class' attribute from the attributes collection.
		//
		if ($this->attributes->has('class')) {
			if (config('forms.attributes--merge-attr-classes', false)) {
				$this->addClass ($this->attributes->get('class'));
			}
			$this->removeAttribute ('class');
		}
		
		return $this->attributes->union(['class' => $this->classes->implode (' ')]);

	}

	
	// Get Attributes
	//
	// Gathers all attributes for this field, including classes, and returns them as an AttributeBag. This is used when rendering the field to pass all attributes to the blade template.
	//
	// @return AttributeBag
	//
	public function getAttributes (): ComponentAttributeBag {

		$attrs = $this->joinAttributes()->toArray();
		
		foreach ($attrs as $name => $value) {
			
			// Translate Placeholder Text, Descriptions, Captions, & Alt Texts
			$translateAttrs = config('forms.attributes--translations',['placeholder', 'description', 'caption', 'alt']);
			if (in_array ($name, $translateAttrs)) {
				$attrs[$name] = __($value);
			}
			else {
				$attrs[$name] = $value;
			}
		}
		
		return new ComponentAttributeBag ($attrs);
		
	}


	// Get Attrs
	//
	// @alias getAttributes
	// @return AttributeBag
	//
	public function getAttrs (): ComponentAttributeBag {
		return $this->getAttributes();
	}


	// Get Attributes Except
	//
	// Gathers all attributes for this field, including classes, and returns them as an AttributeBag, but with out This is used when rendering the field to pass all attributes to the blade template.
	//
	// @param Collection|array|string $except - A collection, array, or spaced string of keys to exclude from the attributes array.
	// @return AttributeBag
	//
	public function getAttributesExcept (Collection|array|string|null $except = null): ComponentAttributeBag {

		if (is_null ($except)) {
			$except = collect([]);
		}
		if (is_string ($except)) {
			$except = explode (' ', $except);
		}
		if (is_array ($except)) {
			$except = collect ($except);
		}
		
		$attrs = $this->joinAttributes()->except($except)->toArray();
		
		foreach ($attrs as $name => $value) {
			
			// Translate Placeholder Text, Descriptions, Captions, & Alt Texts
			$translateAttrs = config('forms.attributes--translations',['placeholder', 'description', 'caption', 'alt']);
			if (in_array ($name, $translateAttrs)) {
				$attrs[$name] = __($value);
			}
			else {
				$attrs[$name] = $value;
			}
		}
		
		return new ComponentAttributeBag ($attrs);
	}


	// Get Attrs Except
	//
	// @alias getAttributesExcept
	// @param Collection|array|string $except - A collection, array, or spaced string of keys to exclude from the attributes array.
	// @return AttributeBag
	//
	public function getAttrsExcept (Collection|array|string|null $except = null): ComponentAttributeBag {
		return $this->getAttributes($except);
	}
	
	
}