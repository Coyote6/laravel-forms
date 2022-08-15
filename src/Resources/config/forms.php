<?php

return [	
	
	/*
	|--------------------------------------------------------------------------
	| Cache
	|--------------------------------------------------------------------------
	|
	| Cache the form templates to skip checking folders for custom templates.
	| If turned on, once a template is found it is stored in the cache for that
	| field and form.  To release the cache either set the field or form's cache
	| property to false. $form->cache = false, $field->cache = false or set this
	| config to false to refresh all forms.
	|
	| If double check is set to true it will double check the existance of a
	| cached template, before attempting to output the form or field. Set to
	| false to save time checking its existance.
	|
	| @return bool
	|
	*/
	'cache' => env('FORM_CACHE', true),
	'cache--double-check' => true,
	
    
	/*
	|--------------------------------------------------------------------------
	| Display Elements
	|--------------------------------------------------------------------------
	|
	| Determines whether to show the element tags on all forms, unless
	| overriden on the individual form.
	|
	| @return bool
	|
	*/
	'display--colon-tag' => false,
	'display--required-tag' => true,
	'display--error-icon' => true,
	
	
	/*
    |--------------------------------------------------------------------------
    | Default Theme & Default Class Usage
    |--------------------------------------------------------------------------
    |
    | The default theme automatically styles any forms or elements that do not
    | have a theme set manually on the item.
    |
	| @return string
	| 
    */
    'default-theme' => env('FORM_DEFAULT_THEME', 'default'),
    
    /*
    |--------------------------------------------------------------------------
    | Default Class Usage
    |--------------------------------------------------------------------------
    |
    | The default classes sets whether to add the classes unstyled classes to
    | help you to target elements with CSS & Js. (Ex. 'form-item--radios' will
    | be added to radio form items.)
    |
    | You can also add your own classes in the default classes section that
    | will be added or removed from items, unless overridden by a specific
    | theme. To make custom themes see the Custom Themes section for more info.
    |
	| @return bool
	| 
    */	
    'default-classes' => env('FORM_DEFAULT_CLASSES', true),	
	
		    
	/*
	|--------------------------------------------------------------------------
	| Default Classes
	|--------------------------------------------------------------------------
	|
	| Sets the default classes for form items, labels, inputs, and errors. 
	|
	|
	*/
	'classes--form' => '',
	'classes--colon' => '',
	'classes--required' => '',
	
	//
	// Append '--' and the field type to the end to target specific types of fields:
	//
	//		'classes--form-item--text' => 'will add classes to the form item tag on all text fields'
	//		'classes--field--select' => 'will add classes to the select tag on all select fields'
	//
	
	//
	// Form Item Containers
	//
	'classes--form-item' => '',
	'classes--form-item--checkbox' => '',
	'classes--form-item--radio' => '',
	'classes--form-item--field-group' => '',
	'classes--form-item--radios' => '',
	'classes--form-item--file' => '',
	'classes--form-item--image' => '',
	'classes--form-item--textarea' => '',
	
	//
	// Label Containers
	//
	'classes--label-container' => '',
	
	//
	// Labels
	//
	'classes--label' => '',
	
	'classes--label--autofill' => '',
	'classes--label--date' => '',
	'classes--label--email' => '',
	'classes--label--number' => '',
	'classes--label--password' => '',
	'classes--label--text' => '',
	'classes--label--textarea' => '',
	'classes--label--file' => '',
	'classes--label--image' => '',
	'classes--label--html' => '',
	'classes--label--button' => '',
	'classes--label--submit' => '',
	'classes--label--checkbox' => '',
	'classes--label--select' => '',
	'classes--label--radio' => '',
	'classes--label--radios' => '',
	'classes--label--field-group' => '',
		
	//
	// Label Texts - <span> inside of the <label> the wraps the text
	//
	'classes--label-text' => '',
	
	'classes--label-text--checkbox' => '',
	'classes--label-text--radio' => '',
	
	//
	// Field Containers
	//
	'classes--field-container' => '',	
	
	'classes--field-container--email' => '',
	'classes--field-container--date' => '',
	'classes--field-container--number' => '',
	'classes--field-container--password' => '',
	'classes--field-container--text' => '',
	'classes--field-container--textarea' => '',
	'classes--field-container--select' => '',
	'classes--field-container--button' => '',
	'classes--field-container--submit' => '',
	
	//
	// Fields
	//
	'classes--field' => '',
	
	'classes--field--autofill' => '',
	'classes--field--date' => '',
	'classes--field--email' => '',
	'classes--field--number' => '',
	'classes--field--password' => '',
	'classes--field--text' => '',
	'classes--field--textarea' => '',
	'classes--field--select' => '',
	'classes--field--checkbox' => '',
	'classes--field--radio' => '',
	'classes--field--file' => '',
	'classes--field--image' => '',
	'classes--field--button' => '',
	
	//
	// Errors
	//
	'classes--error--form-item' => '',
    'classes--error--label-container' => '',
    'classes--error--label' => '',
    'classes--error--field-container' => '',
    
    'classes--error--field'=> '',
    'classes--error--field--autofill' => '',
    'classes--error--field--date' => '',
    'classes--error--field--email' => '',
    'classes--error--field--number' => '',
    'classes--error--field--password' => '',
    'classes--error--field--text' => '',
	'classes--error--field--textarea' => '',
	'classes--error--field--select' => '',
	
	'classes--error--icon-container' => '',
	
	'classes--error--icon-container--autofill' => '',
	'classes--error--icon-container--date' => '',
	'classes--error--icon-container--email' => '',
	'classes--error--icon-container--number' => '',
	'classes--error--icon-container--password' => '',
	'classes--error--icon-container--text' => '',
	'classes--error--icon-container--textarea' => '',
	'classes--error--icon-container--select' => '',
	'classes--error--icon-container--checkbox' => '',
	'classes--error--icon-container--radios' => '',
	'classes--error--icon-container--file' => '',
	'classes--error--icon-container--image' => '',
	'classes--error--icon-container--button' => '',
	'classes--error--icon-container--field-group' => '',

    'classes--error--icon' => '',
	
    'classes--error--message-container' => '',
    'classes--error--message' => '',
    
    'classes--error--message--autofill' => '',
    'classes--error--message--date' => '',
    'classes--error--message--email' => '',
    'classes--error--message--number' => '',
    'classes--error--message--password' => '',
    'classes--error--message--text' => '',
    'classes--error--message--textarea' => '',
    'classes--error--message--select' => '',

   
	// Remove these classes on error
	'remove-classes--error--label' => '',
	'remove-classes--error--field' => '',
	
	'remove-classes--error--field--autofill' => '',
	'remove-classes--error--field--date' => '',
	'remove-classes--error--field--email' => '',
	'remove-classes--error--field--number' => '',
	'remove-classes--error--field--password' => '',
	'remove-classes--error--field--text' => '',
	'remove-classes--error--field--textarea' => '',
	'remove-classes--error--field--select' => '',

             
    /*
    |--------------------------------------------------------------------------
    | Custom Themes 
    |--------------------------------------------------------------------------
    |
    | Create custom themes for forms and their fields. 
    |
    | To Use:
    |	1. First create the theme name you wish to use:
    |			
    |			your-theme-name
    |
    |
    |	2. Second add your theme name followed by '--' and any 'classes' or 'remove-classes' config
    |		you want to add your custom css classes to:
    |
    |			'your-theme-name--classes-form' => 'custom classes to add to form elements'
    |			'your-theme-name--classes-lavel-email' => 'custom classes to add to email elements'
    |
    |
    |	3. Now when creating your form or field, set the theme property and those classes will
    |		be applied instead of the default ones:
    |
    |			$form = new Form();
    |			$form->theme('your-theme-name');
    |			$form->text()->theme = 'your-theme-name';
    |
    |	4. You can also override the file template for that form or field by copying the blade
    |		template into your resources/views/ directory using one of the following conventions:
    |
    |			resources/views/forms/{$your_theme_name}/{$template}.blade.php
	|			resources/views/forms/{$template}--{$your_theme_name}.blade.php
	|
	|	5. If you want to use the base classes of another theme, set the parent theme for your theme.
	|
	|			'your-theme-name--parent-theme' => 'default'
    |
    |			
    |
    */
    
    
    
    //
    // Default Theme
    //
    
    'default--classes--form' => 'm-10 p-10',
	'default--classes--required' => 'text-red-500',
	
	'default--classes--form-item' => 'mt-6',
	'default--classes--form-item--checkbox' => 'relative',
	'default--classes--form-item--radio' => 'relative',
	'default--classes--form-item--field-group' => 'relative',
	'default--classes--form-item--radios' => 'relative',
	'default--classes--form-item--file' => 'flex items-center',
	'default--classes--form-item--image' => 'flex items-center',
	'default--classes--form-item--textarea' => 'relative',

	'default--classes--label' => 'text-cool-gray-700 text-sm leading-5 font-medium focus:outline-none focus:text-cool-gray-800 focus:underline transition duration-150 ease-in-out',
	
	'default--classes--label--autofill' => 'font-semibold',
	'default--classes--label--date' => 'font-semibold',
	'default--classes--label--email' => 'font-semibold',
	'default--classes--label--number' => 'font-semibold',
	'default--classes--label--password' => 'font-semibold',
	'default--classes--label--text' => 'font-semibold',
	'default--classes--label--textarea' => 'font-semibold',
	'default--classes--label--file' => 'font-semibold cursor-pointer py-2 px-3 border border-gray-300 rounded-md hover:text-gray-500 active:bg-gray-50 active:text-gray-800',
	'default--classes--label--image' => 'font-semibold cursor-pointer py-2 px-3 border border-gray-300 rounded-md hover:text-gray-500 active:bg-gray-50 active:text-gray-800',
	'default--classes--label--html' => 'font-semibold',
	'default--classes--label--button' => 'font-semibold',
	'default--classes--label--submit' => 'font-semibold',
	'default--classes--label--checkbox' => 'flex items-center',
	'default--classes--label--select' => 'font-semibold',
	'default--classes--label--radio' => 'flex items-center',
	'default--classes--label--radios' => 'font-semibold',
	'default--classes--label--field-group' => 'font-semibold',

	'default--classes--label-text--checkbox' => 'ml-2',
	'default--classes--label-text--radio' => 'ml-2',	
	
	'default--classes--field-container--email' => 'relative mt-1 rounded-md shadow-sm',
	'default--classes--field-container--date' => 'relative mt-1 rounded-md shadow-sm',
	'default--classes--field-container--number' => 'relative mt-1 rounded-md shadow-sm',
	'default--classes--field-container--password' => 'relative mt-1 rounded-md shadow-sm',
	'default--classes--field-container--text' => 'relative mt-1 rounded-md shadow-sm',
	'default--classes--field-container--textarea' => 'relative mt-1 rounded-md shadow-sm',
	'default--classes--field-container--select' => 'relative mt-1 rounded-md shadow-sm',
	'default--classes--field-container--button' => 'flex space-x-2',
	'default--classes--field-container--submit' => 'flex space-x-2',
		
	'default--classes--field--autofill' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'default--classes--field--date' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'default--classes--field--email' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'default--classes--field--number' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'default--classes--field--password' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'default--classes--field--text' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'default--classes--field--textarea' => 'form-textarea appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'default--classes--field--select' => 'form-select block mt-1 w-full',
	'default--classes--field--checkbox' => 'form-checkbox',
	'default--classes--field--radio' => 'form-radio',
	'default--classes--field--file' => 'form-input',
	'default--classes--field--image' => 'form-input',
	'default--classes--field--button' => 'form-input',
	
	'default--classes--error--form-item' => 'has-error has-error--form-item',
    'default--classes--error--label-container' => 'has-error has-error--label-container',
    'default--classes--error--label' => 'error error--label text-red-700',
    'default--classes--error--field-container' => 'has-error has-error--field-container',
    
    'default--classes--error--field'=> 'error error--field text-red-700',
    'default--classes--error--field--autofill' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
    'default--classes--error--field--date' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
    'default--classes--error--field--email' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
    'default--classes--error--field--number' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
    'default--classes--error--field--password' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
    'default--classes--error--field--text' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
	'default--classes--error--field--textarea' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
	'default--classes--error--field--select' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
	
	'default--classes--error--icon-container' => 'absolute inset-y-0 right-0 pr-3 flex pointer-events-none',
	
	'default--classes--error--icon-container--autofill' => 'items-center',
	'default--classes--error--icon-container--date' => 'items-center',
	'default--classes--error--icon-container--email' => 'items-center',
	'default--classes--error--icon-container--number' => 'items-center',
	'default--classes--error--icon-container--password' => 'items-center',
	'default--classes--error--icon-container--text' => 'items-center',
	'default--classes--error--icon-container--textarea' => 'items-center',
	'default--classes--error--icon-container--select' => 'items-center',
	'default--classes--error--icon-container--checkbox' => 'items-center',
	'default--classes--error--icon-container--radios' => 'items-start mt-1',
	'default--classes--error--icon-container--file' => 'items-center',
	'default--classes--error--icon-container--image' => 'items-center',
	'default--classes--error--icon-container--button' => 'items-center',
	'default--classes--error--icon-container--field-group' => 'items-start mt-1',

    'default--classes--error--icon' => 'h-5 w-5 text-red-500',
	
    'default--classes--error--message-container' => 'has-error has-error--message-container',
    'default--classes--error--message' => 'error error--message text-xs text-red-700 block',
	
	'default--classes--error--message--autofill' => 'mt-2',
    'default--classes--error--message--date' => 'mt-2',
    'default--classes--error--message--email' => 'mt-2',
    'default--classes--error--message--number' => 'mt-2',
    'default--classes--error--message--password' => 'mt-2',
    'default--classes--error--message--text' => 'mt-2',
    'default--classes--error--message--textarea' => 'mt-2',
    'default--classes--error--message--select' => 'mt-2',
    
    'default--remove-classes--error--label' => 'text-cool-gray-700',
	'default--remove-classes--error--field' => 'border-gray-300',
	
	'default--remove-classes--error--field--autofill' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'default--remove-classes--error--field--date' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'default--remove-classes--error--field--email' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'default--remove-classes--error--field--number' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'default--remove-classes--error--field--password' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'default--remove-classes--error--field--text' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'default--remove-classes--error--field--textarea' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'default--remove-classes--error--field--select' => 'focus:border-blue-300 focus:shadow-outline-blue',
 
    
    //
    // Minimal
    //
    'minimal--parent-theme' => 'default',
	'minimal--classes--form' => '',
	'minimal--classes--required' => 'text-red-500',


	//
	// CRUD (Create Read Update Delete)
	// 
	//	Used by coyote6/laravel-crud
	//
	
    'minimum--parent-theme' => 'default',
	'crud--classes--form' => '',
	'crud--classes--form-item' => 'flex justify-between items-center',
	
	'crud--classes--label' => 'mr-2 text-sm font-medium leading-5 text-gray-700',
	'crud--classes--label--select' => '',
	
	'crud--classes--field-container--email' => 'relative rounded-md shadow-sm',
	'crud--classes--field-container--date' => 'relative rounded-md shadow-sm',
	'crud--classes--field-container--number' => 'relative rounded-md shadow-sm',
	'crud--classes--field-container--password' => 'relative rounded-md shadow-sm',
	'crud--classes--field-container--text' => 'relative rounded-md shadow-sm',
	'crud--classes--field-container--textarea' => 'relative rounded-md shadow-sm',
	'crud--classes--field-container--select' => 'relative rounded-md shadow-sm',

	'crud--classes--field--select' => 'text-sm font-medium text-gray-700 form-select block w-full',

];

