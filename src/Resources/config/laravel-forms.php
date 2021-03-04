<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Form Theme
    |--------------------------------------------------------------------------
    |
    | This value sets the default classes that are added to forms and their fields.
    | Optional values are null or 'tailwind'.
    |
    |	Future values: 'coyote6', 'drupal', 'bootstap' 
    |
    */

    'theme' => env('FORM_THEME', null),


    /*
    |--------------------------------------------------------------------------
    | Display Containers
    |--------------------------------------------------------------------------
    |
    | Determines whether to show the element tags on all forms, unless
    |	overriden on the individual form.
    |
    |	Available Values = true, false, 'auto'
    |
    */
    'display--colon-tag' => 'auto',
    'display--required-tag' => 'auto',
    'display--form-item-tag' => 'auto',
    'display--label-container-tag' => 'auto',
    'display--label-tag' => 'auto',
    'display--label-text-tag' => 'auto',									// Adds an additional span tag inside the label for styling purposes.
    																											// Off by default except radio buttons and checkboxes.
    																											// Use the setting display--error-message-container-tag => true to always display
    																											// or $field->errorMessageContainerTag()->displayElement() to display on individual field.
    'display--field-container-tag' => 'auto',
    'display--error-message-container-tag' => 'auto',			// Off by default. Use the setting display--error-message-container-tag => true to always display
    																											// or $field->errorMessageContainerTag()->displayElement() to display on individual field.
		'display--error-icon-container' => 'auto',
		'display--error-icon' => 'auto',
		    
    /*
    |--------------------------------------------------------------------------
    | Default Classes 
    |--------------------------------------------------------------------------
    |
    | Sets the default classes for form items, labels, inputs, and classes. 
    |
    */
    'default-classes' => env('FORM_DEFAULT_CLASSES', true),		
    'classes--colon' => 'colon',
    'classes--required' => 'required',
        
     /*
    |--------------------------------------------------------------------------
    | Default Error Classes
    |--------------------------------------------------------------------------
    |
    | The default error classes to use when an error occurs.  These are
    | overridden when a theme is selected.
    |
    */
    'classes--error--form-item' => 'has-error has-error--form-item',
    'classes--error--label-container' => 'has-error has-error--label-container',
    'classes--error--label' => 'error error--label',
    'classes--error--field-container' => 'has-error has-error--field-container',
    'classes--error--field' => 'error error--label',
    'classes--error--message-container' => 'has-error has-error--message-container',
    'classes--error--message' => 'error error--message',
    
    
    /*
    |--------------------------------------------------------------------------
    | Tailwind CSS Classes 
    |--------------------------------------------------------------------------
    |
    | Sets the default Tailwind CSS classes for form items, labels, inputs, and classes. 
    |
    */
    'tailwind--classes--required' => 'text-red-500',
    
    'tailwind--classes--form' => 'm-10 p-10 border border-gray-300 rounded-md',
    
    'tailwind--classes--form-item' => 'mt-6',						// Generic classes that will be applied to all form items
    
    'tailwind--classes--form-item--text' => '',
    'tailwind--classes--form-item--textarea' => '',
    'tailwind--classes--form-item--select' => '',
    'tailwind--classes--form-item--checkbox' => 'relative',
    'tailwind--classes--form-item--radio' => 'relative',
    'tailwind--classes--form-item--file' => '',
    'tailwind--classes--form-item--image' => '',
    'tailwind--classes--form-item--button' => '',
    'tailwind--classes--form-item--html' => '',
    'tailwind--classes--form-item--field-group' => 'relative',
    
    'tailwind--classes--label-container' => '',						// Generic classes that will be applied to all label containers
    																											// Display shutoff by default in Tailwind. Use the setting display--label-container-tag => true to always display
    																											// or $field->labelContainerTag()->displayElement() to display on individual field.
    																											
    'tailwind--classes--label-container--text' => '',
    'tailwind--classes--label-container--textarea' => '',
    'tailwind--classes--label-container--select' => '',
    'tailwind--classes--label-container--checkbox' => '',
    'tailwind--classes--label-container--radio' => '',
    'tailwind--classes--label-container--file' => '',
    'tailwind--classes--label-container--image' => '',
    'tailwind--classes--label-container--button' => '',
    'tailwind--classes--label-container--html' => '',
    'tailwind--classes--label-container--field-group' => '',
    
    'tailwind--classes--label' => 'text-gray-700',					// Generic classes that will be applied to all labels
    
    'tailwind--classes--label--text' => 'font-semibold',
    'tailwind--classes--label--textarea' => 'font-semibold',
    'tailwind--classes--label--select' => 'font-semibold',
    'tailwind--classes--label--checkbox' => 'flex items-center',
    'tailwind--classes--label--radio' => 'flex items-center',
    'tailwind--classes--label--file' => 'font-semibold',
    'tailwind--classes--label--image' => 'font-semibold',
    'tailwind--classes--label--button' => 'font-semibold',
    'tailwind--classes--label--html' => 'font-semibold',
    'tailwind--classes--label--field-group' => 'font-semibold',
    
    'tailwind--classes--label-text' => '',								// Generic classes that will be applied to all label text classes.
    																											// Depending of field type the display maybe shutoff in Tailwind. Use the setting display--field-container-tag => true to always display
    																											// or $field->fieldContainerTag()->displayElement() to display on individual field.
    																											
    'tailwind--classes--label-text--checkbox' => 'ml-2',
    'tailwind--classes--label-text--radio' => 'ml-2',
    
    																											
    'tailwind--classes--field-container' => '',						// Generic classes that will be applied to all field containers
    																											// Depending of field type the display maybe shutoff in Tailwind. Use the setting display--field-container-tag => true to always display
    																											// or $field->fieldContainerTag()->displayElement() to display on individual field.

		'tailwind--classes--field-container--text' => 'relative mt-1 rounded-md shadow-sm',
    'tailwind--classes--field-container--textarea' => 'relative mt-1 rounded-md shadow-sm',
    'tailwind--classes--field-container--select' => 'relative mt-1 rounded-md shadow-sm',
    'tailwind--classes--field-container--checkbox' => '',
    'tailwind--classes--field-container--radio' => '',
    'tailwind--classes--field-container--file' => '',
    'tailwind--classes--field-container--image' => '',
    'tailwind--classes--field-container--button' => '',
    'tailwind--classes--field-container--html' => '',
    'tailwind--classes--field-container--field-group' => '',

    'tailwind--classes--field' => '',											// Generic classes that will be applied to all fields.
    'tailwind--classes--field--text' => 'form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
    'tailwind--classes--field--textarea' => 'form-textarea appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
    'tailwind--classes--field--select' => 'form-select block mt-1 w-full',
    'tailwind--classes--field--checkbox' => 'form-checkbox',
    'tailwind--classes--field--radio' => 'form-radio',
    'tailwind--classes--field--file' => 'form-input',
    'tailwind--classes--field--image' => 'form-input',
    'tailwind--classes--field--button' => 'form-input',
    'tailwind--classes--field--html' => '',
    'tailwind--classes--field--field-group' => '',
    
    'tailwind--classes--error-icon-container' => 'absolute inset-y-0 right-0 pr-3 flex pointer-events-none',

    'tailwind--classes--error-icon-container--text' => 'items-center',
    'tailwind--classes--error-icon-container--textarea' => 'items-center',
    'tailwind--classes--error-icon-container--select' => 'items-center',
    'tailwind--classes--error-icon-container--checkbox' => 'items-center',
    'tailwind--classes--error-icon-container--file' => 'items-center',
    'tailwind--classes--error-icon-container--image' => 'items-center',
    'tailwind--classes--error-icon-container--button' => 'items-center',
    'tailwind--classes--error-icon-container--field-group' => 'items-start mt-1',
    
    'tailwind--classes--error-icon' => 'h-5 w-5 text-red-500',

    'tailwind--classes--error-icon--text' => '',
    'tailwind--classes--error-icon--textarea' => '',
    'tailwind--classes--error-icon--select' => '',
    'tailwind--classes--error-icon--checkbox' => '',
    'tailwind--classes--error-icon--file' => '',
    'tailwind--classes--error-icon--image' => '',
    'tailwind--classes--error-icon--button' => '',
    'tailwind--classes--error-icon--field-group' => '',
   
    'tailwind--classes--error--form-item' => 'has-error has-error--form-item',
    'tailwind--classes--error--label-container' => '',
    'tailwind--classes--error--label' => 'text-red-700',
    'tailwind--classes--error--field-container' => '',
    'tailwind--classes--error--field' => 'border border-red-700 text-red-700',
    
    'tailwind--classes--error--field--text' => 'focus:border-red-300 focus:shadow-outline-red',
    'tailwind--classes--error--field--textarea' => 'focus:border-red-300 focus:shadow-outline-red',
    'tailwind--classes--error--field--select' => 'focus:border-red-300 focus:shadow-outline-red',
    
    'tailwind--remove-classes--error--field' => 'border-gray-300',

		'tailwind--remove-classes--error--field--text' => 'focus:border-blue-300 focus:shadow-outline-blue',
    'tailwind--remove-classes--error--field--textarea' => 'focus:border-blue-300 focus:shadow-outline-blue',
    'tailwind--remove-classes--error--field--select' => 'focus:border-blue-300 focus:shadow-outline-blue',
        
    'tailwind--classes--error--message-container' => '',		// Display shutoff by default in Tailwind. Use the setting display--error-message-container-tag => true to always display
    																												// or $field->errorMessageContainerTag()->displayElement() to display on individual field.
    'tailwind--classes--error--message' => 'mt-2 text-xs text-red-700 block',

];
