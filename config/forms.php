<?php

return [	

    //
    // Livewire
    //


    // Livewire Version
    //
    // The major version of Livewire you are using in your project. 
    //
    // Dev Note:
    //      This is used to determine which syntax to use for Livewire directives and model binding.
    //
    'livewire--version' => env('LIVEWIRE_VERSION', 4),

    // Livewire Default Model Binding
	//
    // Choose which type of model binding to use for Livewire components by default. 
    // This can be overridden on individual fields using the livewireDebounce(), livewireLive(), livewireBlur(), livewireDefer(), or livewire() methods.
    //
	// @values ['default', 'live', 'blur', 'debounce', 'defer']
	// @return string
	//
	'livewire--default-model-binding' => (string) env('LIVEWIRE_DEFAULT_MODEL_BINDING', 'default'),


    //
    // Attributes/Classes
    // 


    // Attributes Merge Attr Classes
    //
    // Flag to allow merging of classes set in the 'attributes' array with classes set using the 'class' method. 
    // If false, the 'class' method will override any classes set in the 'attributes' array. 
    // If true, the classes will be merged together.
    //
    // Dev Note: 
    //      Allowing the merging may cause unexpected results when using hasClass() method to check for a class, 
    //      as it will only check the classes set via the 'class' method and not the classes set in the 'attributes' array.
    //      It is recommended to always use setClass()/addClass() methods unless there is a specific need to set classes via the
    //      setAttributes() method or its aliases.
    //
    // @value bool
    //
    'attributes--merge-attr-classes' => false,


    // Attributes Translations
    //
    // An array of attributes names that should be translated for display purposes, such as 'placeholder', 'description', 'caption', and 'alt'.
    //
    // @value []
    //
    'attributes--translations' => ['placeholder', 'description', 'caption', 'alt'],


	//
	// Display Elements
	//
	// Determines whether to show the element tags on all forms, unless
	// overriden on the individual form.
	//


    // Colon Tags
    //
    // Whether to show the colon tag (:) on all fields that have it enabled, unless overridden on the individual field.
    //
    // @value bool
    //
	'display--colon-tag' => false,


    // Required Tags
    //
    // Whether to show the required tag (*) on all fields that have it enabled, unless overridden on the individual field.
    //
    // @value bool
    //
	'display--required-tag' => true,
  

    // Error Icon
    //
    // Whether to show the error icon on all fields that have it enabled, unless overridden on the individual field.
    //
    // @value bool
    //
	'display--error-icon' => true,


    //
    // Themes
    //
	
	
	// Theme
    //
    // The default theme automatically styles any forms or elements that do not
    // have a theme set manually on the item.
	//
	// Predefined themes include:
	//		'flux' - The default theme that comes with the package that utilizes Livewire Flux.
	//		'abyss' - A minimal theme that only adds classes to required fields and errors. No bells or whistles.
    //
	// @return string
    //
    'theme' => env('FORM_THEME', 'flux'),
    
    
    //
    // Custom Themes 
    //
    //
    // Create custom themes for forms and their fields. 
    //
    // To Use:
    //	1. First create the theme folder in your views/forms directory with the name you wish to use:
    //			
    //			resources/views/forms/your-theme-name
    //
    //
    //	2. Copy any templates you wish to customize into that folder. You can copy the entire default
	//		theme if you wish to start with that as a base, or just the templates you want to change.
	//		Make any changes you wish to those templates.
    //
    //
    //	3. Now when creating your form or field, set the theme property and those classes will
    //		be applied instead of the default ones:
    //
    //			$form = new Form();
    //			$form->theme('your-theme-name');			// Changes the theme for the entire form
    //			$form->text()->theme('your-theme-name');	// Changes the theme for just this field
    //
    //		You can also override the file template for any specfic form or field by using the template property. 
	//		This will look for a template with the name of the template property in the theme folder first, then in 
	//		the default theme folder, and if it doesn't find it there it will use the base template.
    //
    //			resources/views/forms/{$your_theme_name}/{$template}.blade.php
	//			resources/views/forms/{$template}--{$your_theme_name}.blade.php
    //		
    //
    
    

];

