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
	| Available Values = true or false
	|
	*/
	'cache' => env('FORM_CACHE', true),
	'cache--double-check' => true,
	
	
	/*
    |--------------------------------------------------------------------------
    | Default Classes 
    |--------------------------------------------------------------------------
    |
    | Sets the default classes for form items, labels, inputs, and classes. 
    |
    */
    'default-classes' => env('FORM_DEFAULT_CLASSES', true),	
    
	/*
	|--------------------------------------------------------------------------
	| Display Elements
	|--------------------------------------------------------------------------
	|
	| Determines whether to show the element tags on all forms, unless
	| overriden on the individual form.
	|
	| Available Values = true or false
	|
	*/
	'display--colon-tag' => false,
	'display--required-tag' => true,
	'display--error-icon' => true,
	
		    
	/*
	|--------------------------------------------------------------------------
	| Default Classes 
	|--------------------------------------------------------------------------
	|
	| Sets the default classes for form items, labels, inputs, and classes. 
	|
	|
	*/
	'classes--form' => 'm-10 p-10 border border-gray-300 rounded-md',
	'classes--colon' => '',
	'classes--required' => 'text-red-500',
	
	//
	// Append '--' and the field type to the end to target specific types of fields:
	//
	//		'classes--form-item--text' => 'will add classes to the form item tag on all text fields'
	//		'classes--field--select' => 'will add classes to the select tag on all select fields'
	//
	
	//
	// Form Item Containers
	//
	'classes--form-item' => 'mt-6',
	'classes--form-item--checkbox' => 'relative',
	'classes--form-item--radio' => 'relative',
	'classes--form-item--field-group' => 'relative',
	'classes--form-item--radios' => 'relative',
	'classes--form-item--file' => 'flex items-center',
	'classes--form-item--image' => 'flex items-center',
	'classes--form-item--textarea' => 'relative',
	
	//
	// Label Containers
	//
	'classes--label-container' => '',
	
	//
	// Labels
	//
	'classes--label' => 'text-cool-gray-700 text-sm leading-5 font-medium focus:outline-none focus:text-cool-gray-800 focus:underline transition duration-150 ease-in-out',
	
	'classes--label--date' => 'font-semibold',
	'classes--label--email' => 'font-semibold',
	'classes--label--number' => 'font-semibold',
	'classes--label--password' => 'font-semibold',
	'classes--label--text' => 'font-semibold',
	'classes--label--textarea' => 'font-semibold',
	'classes--label--file' => 'font-semibold cursor-pointer py-2 px-3 border border-gray-300 rounded-md hover:text-gray-500 active:bg-gray-50 active:text-gray-800',
	'classes--label--image' => 'font-semibold cursor-pointer py-2 px-3 border border-gray-300 rounded-md hover:text-gray-500 active:bg-gray-50 active:text-gray-800',
	'classes--label--html' => 'font-semibold',
	'classes--label--button' => 'font-semibold',
	'classes--label--submit' => 'font-semibold',
	'classes--label--checkbox' => 'flex items-center',
	'classes--label--select' => 'font-semibold',
	'classes--label--radio' => 'flex items-center',
	'classes--label--radios' => 'font-semibold',
	'classes--label--field-group' => 'font-semibold',
		
	//
	// Label Texts - <span> inside of the <label> the wraps the text
	//
	'classes--label-text' => '',
	
	'classes--label-text--checkbox' => 'ml-2',
	'classes--label-text--radio' => 'ml-2',
	
	//
	// Field Containers
	//
	'classes--field-container' => '',	
	
	'classes--field-container--email' => 'relative mt-1 rounded-md shadow-sm',
	'classes--field-container--date' => 'relative mt-1 rounded-md shadow-sm',
	'classes--field-container--number' => 'relative mt-1 rounded-md shadow-sm',
	'classes--field-container--password' => 'relative mt-1 rounded-md shadow-sm',
	'classes--field-container--text' => 'relative mt-1 rounded-md shadow-sm',
	'classes--field-container--textarea' => 'relative mt-1 rounded-md shadow-sm',
	'classes--field-container--select' => 'relative mt-1 rounded-md shadow-sm',
	'classes--field-container--button' => 'flex space-x-2',
	'classes--field-container--submit' => 'flex space-x-2',
	
	//
	// Fields
	//
	'classes--field' => '',
	
	'classes--field--date' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'classes--field--email' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'classes--field--number' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'classes--field--password' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'classes--field--text' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'classes--field--textarea' => 'form-textarea appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
	'classes--field--select' => 'form-select block mt-1 w-full',
	'classes--field--checkbox' => 'form-checkbox',
	'classes--field--radio' => 'form-radio',
	'classes--field--file' => 'form-input',
	'classes--field--image' => 'form-input',
	'classes--field--button' => 'form-input',
	
	//
	// Errors
	//
	'classes--error--form-item' => 'has-error has-error--form-item',
    'classes--error--label-container' => 'has-error has-error--label-container',
    'classes--error--label' => 'error error--label text-red-700',
    'classes--error--field-container' => 'has-error has-error--field-container',
    
    'classes--error--field'=> 'error error--field text-red-700',
    'classes--error--field--date' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
    'classes--error--field--email' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
    'classes--error--field--number' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
    'classes--error--field--password' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
    'classes--error--field--text' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
	'classes--error--field--textarea' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
	'classes--error--field--select' => 'focus:border-red-300 focus:shadow-outline-red border border-red-700',
	
	'classes--error--icon-container' => 'absolute inset-y-0 right-0 pr-3 flex pointer-events-none',
	
	'classes--error--icon-container--date' => 'items-center',
	'classes--error--icon-container--email' => 'items-center',
	'classes--error--icon-container--number' => 'items-center',
	'classes--error--icon-container--password' => 'items-center',
	'classes--error--icon-container--text' => 'items-center',
	'classes--error--icon-container--textarea' => 'items-center',
	'classes--error--icon-container--select' => 'items-center',
	'classes--error--icon-container--checkbox' => 'items-center',
	'classes--error--icon-container--radios' => 'items-start mt-1',
	'classes--error--icon-container--file' => 'items-center',
	'classes--error--icon-container--image' => 'items-center',
	'classes--error--icon-container--button' => 'items-center',
	'classes--error--icon-container--field-group' => 'items-start mt-1',

    'classes--error--icon' => 'h-5 w-5 text-red-500',
	
    'classes--error--message-container' => 'has-error has-error--message-container',
    'classes--error--message' => 'error error--message text-xs text-red-700 block',
    
    'classes--error--message--date' => 'mt-2',
    'classes--error--message--email' => 'mt-2',
    'classes--error--message--number' => 'mt-2',
    'classes--error--message--password' => 'mt-2',
    'classes--error--message--text' => 'mt-2',
    'classes--error--message--textarea' => 'mt-2',
    'classes--error--message--select' => 'mt-2',

   
	// Remove these classes on error
	'remove-classes--error--label' => 'text-cool-gray-700',
	'remove-classes--error--field' => 'border-gray-300',
	
	'remove-classes--error--field--date' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'remove-classes--error--field--email' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'remove-classes--error--field--number' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'remove-classes--error--field--password' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'remove-classes--error--field--text' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'remove-classes--error--field--textarea' => 'focus:border-blue-300 focus:shadow-outline-blue',
	'remove-classes--error--field--select' => 'focus:border-blue-300 focus:shadow-outline-blue',

             
    /*
    |--------------------------------------------------------------------------
    | Custom Theme Classes 
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
    |			$form->theme = 'your-theme-name';
    |			$field = $form->text();
    |			$field->theme = 'your-theme-name';
    |
    |	4. You can also override the file template for that form or field by copying the blade
    |		template into your resources/views/ directory using one of the following conventions:
    |
    |			resources/views/forms/{$your_theme_name}/{$template}.blade.php
	|			resources/views/forms/{$template}--{$your_theme_name}.blade.php
    |
    |			
    |
    */
    
    'minimal--classes--form' => 'form',

];

