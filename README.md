# Laravel Forms

## About The Project
Laravel Forms is just a simple class used to generate the html for forms and assist with simple validation process in Laravel.  This project is still in development, so documentation will be slow going.

## Prerequisites
* PHP 7.2 or Higher
* Laravel Install

## Getting Started
Install via composer:
```sh
composer require coyote6/laravel-forms
```

Optional - Copy the config file to your config folder.
```sh
php artisan vendor:publish --tag=laravel-forms
```

## To Use

### Basic Example
#### In the controller file
```php
use Coyote6\LaravelForms\Form\Form;

$form = new Form();

$field1 = $form->text('field-name--1');		// Returns the field object
$field1->addRule ('min', '5');
$field1->label = 'Field 1';
$field1->required();

$form->textarea ('field-name--2')
	->label('Field 2')						// Chained label and placeholder
	->placeholder('Field 2');
```
#### In Blade Template
``` PHP
{!! $form !!}
```


### Best Practice
For best use it is recommended to set up the form in the controller under its own private/protected method, so that it may be reused for validation.

#### In the controller file
```php

namespace App\Http\Controllers;

use Coyote6\LaravelForms\Form\Form;
use Illuminate\Http\Request;


class HomeController extends Controller  {
	
	
	protected function form () {

		static $form;						// Create a singleton to keep form ids the same when validating.
		
		if (is_null ($form)) {
			$form = new Form();
			$form->action ('/home');		// Default action is '#' so it will submit to the same page if not set.
			$form->method ('POST');			// Available methods GET, POST, PUT, or DELETE
			
			$form->email('email')	
				->placeholder ('Please, Enter Your Email Address')
				->required();
			
			$form->checkbox ('tos')
				->label ('You must agree to our ToS.')
				->required();
		}
		
		return $form;
		
	}


	public function create () {
		return view ('home',['form'=> $this->form()]);
	}
	
	
	public function store () {
		$this->form()->validate();
		return ['success'];
	}

}

```


### Validation
```php
$form = new Form();
$form->action ('/home')
	->method ('PUT');

$form->text ('username')
	->label ('Username')
	->required()
	->addRules (['min:8', 'max:255', 'unique:users']);	// Add laravel validation rules as an array.

$form->email ('email')
	->label ('Email')
	->required()
	->addRule ('max:255')								// Add laravel validation rules individually
	->addRule ('unique', 'users')
	->confirm()											// Automatically adds extra confirm field and validates it.
	->label ('Email Confirmation');						// Return value is the confirmation field.

$form->password ('password')
	->label ('Password')
	->required()
	->addRules (['min:5', 'max:255'])
	->removeRule ('max')								// Remove rules by their name
	->confirm()
	->label ('Password Confirmation');

// Default submit button gets automatically added, unless told otherwise.
if (isset ($_POST['submit'])) {
	$validatedData = $form->validate();
	return $validatedData;
}
```


### Use with Livewire
#### In the your base app blade template, below where you call @livewireScripts, add a stack('scripts') call if you haven't already done so.
```php
@stack('scripts')
```

#### In the component (Basic Method)
```php
 
namespace App\Http\Livewire;
 
use Livewire\Component;
use Coyote6\LaravelForms\Form\Form;
 
class Example extends Component {
	 
	 
	public $email = '';
	public $password = '';
	public $passwordConfirmation = '';
	
	
	protected function rules() {
		return $this->form()->lwRules();					// lwRules() is an alias to livewireRules()
	}
    	
	public function updated ($field) {
		$this->validateOnly($field);
	}
	
	
	public function render () {
		return view ('livewire.example', ['form' => $this->form()]);		
	}
	
	 
	public function store () {
		
		$values = $this->validate();  
		return ['success' => $values];
		
	}
	
	
	// Optionally set up a store method as a fallback in case someone shuts off JavaScript
	public function storeFallback () {
		$values = $this->form()->validate();
		return ['success' => $values];
	}
	
	
	public function form () {
		
		static $form;										// Create a singleton to keep form ids the same when validating.
		
		if (is_null ($form)) {
			
			$form = new Form ($this);						// Sets up the form as a Livewire form... 
															// alternatively you can call $form->isLivewireForm($this);	
											
			$form->action ('/store')						// Optional fallback in case someone shuts off Javascript
				->method('POST')
				->addAttribute ('wire:submit.prevent', 'store');
			
			$form->email ('email')
				->label ('Email')
				->livewireModel ('email')
				->required()
				->addRule('unique:users');
			
			$p = $form->password ('password')
				->label ('Password')
				->lwModel()									// lwModel() & lw() are aliases to livewireModel() method
															// If no value is passed, the name is used for the livewire model.
				->addRule ('min:6');
			
			$pc = $p->confirm();
			$pc->label ('Confirm Password')
				->lwModelLazy ('passwordConfirmation');		// Use livewireModelLazy(), lwModelLazy(), lwLazy() to call wire:model.lazy 
			
			//
			// Use getLivewireModel(), getLwModel(), getLw() methods to retrieve the Livewire model name.
			// $pc->getLw();
			//
		
		}
		return $form;
		
	}
	
}
```
#### In the component (Using Coyote6\LaravelForms\Livewire\Component)
```php
 
namespace App\Http\Livewire;
 
use Coyote6\LaravelForms\Livewire\Component;
use Coyote6\LaravelForms\Form\Form;
 
class Example extends Component {
	 
	 
	public $email = '';
	public $password = '';
	public $passwordConfirmation = '';
	
	
	// Optional
	public function template () {
		return 'livewire.example';
	}	
	 
	public function store () {
		
		$values = $this->validate();  
		return ['success' => $values];
		
	}
	
	
	// Optionally set up a store method as a fallback in case someone shuts off JavaScript
	public function storeFallback () {
		$values = $this->form()->validate();
		return ['success' => $values];
	}
	
	
	public function generateForm () {
		
		$form = new Form ([
			'lw' => $this, 
			'cache' => false,
			'theme' => 'minimal'
		]);
		
		$form->addAttribute ('wire:submit.prevent', 'store');
		
		$form->email ('email')
			->lwLazy()
			->label ('Email')
			->required()
			->addRule('unique:users');
		
		$form->password ('password')
			->lwLazy()
			->label ('Password')
			->addRule ('min:6')
			->confirm()
			->label ('Confirm Password')
			->lwLazy ('passwordConfirmation');
		
		$form->submitButton ('submit')
			->content ('Comfirm');

		return $form;

	}
	
}
```
#### In the Livewire Blade Template
``` PHP
{!! $form !!}
```
#### In the Web Routes File -- Optional
``` PHP
Route::post('/store', 'App\Http\Livewire\Example@storeFallback');

```

### Use with Tailwind CSS
Tailwind is now the default theming for the forms.  You must already have tailwind purchased, installed, and configured.

Some non-tailwind classes are added to items automatically.  These are generic class names such as .form-item, .label, .field, etc.  You can shut them off in the .env file using:
```
FORM_DEFAULT_CLASSES=false
```
Or if you published the config file, you can set `default-classes` to false.

If you wish to change the default tailwind classes, they are stored in the classes section of the config file.  Additional styling options are set in there as well.

### Theming
You can theme the forms in a couple ways.  

The first which is mentioned above is to edit the config file and overriding the classes.

The other is to copy the files from the -/src/Resources/views/- directory (sorry haven't wrote the publish command yet, but will.) and move any of these files into -resources/views/- directory in your app. The package will check your directory for files and use it over the default files. Be sure to set caching to false on either your individual form/field or set the master caching to false in the config.  The template naming conventions are as follows:

-resources/views/forms.{$template}--{$element_id}.blade.php-
-resources/views/forms.{$template}--{$element_name}.blade.php-
-resources/views/forms.{$theme}.{$template}.blade.php-
-resources/views/forms.{$template}--{$theme}.blade.php-
-vendor/coyote6/laravel-forms/src/resources/views/forms.{$theme}.{$template}.blade.php-
-vendor/coyote6/laravel-forms/src/resources/views/forms.{$template}--{$theme}.blade.php-
-resources/views/forms.{$template}.blade.php-
-vendor/coyote6/laravel-forms/src/resources/views/forms.{$template}.blade.php-

You can merge your custom classes to any of the attribute variables in the templates:
```php
<div {{ $attributes->merge([
	'class' => 'new classes'
]) }}></div>
// Or
<x-component :attributes="$attributes->merge(['class'=>'new classes'])"></x-component>
```

To utilize a theme on certain forms, and set classes from the config method, set the theme when constructing the form.
```php
$form = new Form (['theme' => 'minimal']);
```

If you just with to override the templates without setting classes from the config file, then you can call it anytime before rendering or validating.
```php
$form->theme = 'minimal';
$field->theme = 'minimal';
```

Fields will inherit their parent's theme if it is set during the construction, or before fields are added.


### Available Fields (More to come)
#### Button - &lt;button&gt;
```php

$form->button ('field-name')
	->value ('Button Value')								// Is the default button content unless the content property is set.
	->content ('This is what shows inside the button');

```

#### Checkbox - &lt;input type="checkbox"&gt;
```php

$form->checkbox ('field-name')
	->value ('Value when submitted')	
	->label ('Click me');

```

#### Email - &lt;input type="email"&gt;
##### Simple Email
```php

$form->email ('field-name');

```

##### Email w/ Confirmation
```php

$form->email ('field-name')
	->label ('Email')
	->confirm()
	->label ('Confirm Email');

```

#### Field Group - &lt;div&gt;
This just wraps a group of fields.  It can have a label, if desired.
```php

$form->fieldGroup ('field-name')
	->label ('Contact Info');

```

#### File - &lt;input type="file"&gt;
```php

$form->file ('field-name')
	->label ('Upload File');

```

#### Hidden - &lt;input type="hidden"&gt;
```php

$form->hidden ('field-name')
	->value = 'some value';

```

#### Html - &lt;div&gt; 
```php

$form->html ('field-name')
	->content  ('<em>Custom Html Field</em>');
	
```

#### Image - &lt;input type="file"&gt;
```php

$form->image ('field-name')
	->label ('Upload Image');

```

#### Number - &lt;input type="number"&gt;
```php

$form->number ('field-name')
	->label ('Enter Your Lucky Number');

```

#### Password - &lt;input type="password"&gt;
##### Simple Password
```php

$form->password ('field-name')
	->label ('Password');
	
```

##### Password w/ Confirm
```php

$p = $form->password ('field-name')
	->label ('Password')
	->confirm()
	->label ('Password Confirm');
	
```

#### Radio Buttons - &lt;input type="radio"&gt;
##### Simple Radio Button
```php

$form->radios ('field-name')
	->label ("Please select an option")
	->addOptions([
	  'o1' => 'Option 1',
	  'o2' => 'Option 2',
	  'o3' => 'Option 3',
	  'o4' => 'Option 4'
	])
	->required();

```

##### Radio Buttons with HTML
```php

$r2 = $form->radios ('field-name')
	->required()
	->value ('o1');  // Set a default value
	    
$rb1 = new Radio ('field-name');
$rb1->label ('Option 1')
	->value ('o1');
	    
$h1 = new Html ('field-name--html-1');
$h1->value ('Cool HTML info about option 1');
	    
$rb2 = new Radio ('field-name');
$rb2->label ('Option 2')
	->value ('o2');

$h2 = new Html ('field-name--html-2');
$h2->value ('Cool HTML info about option 2');

$r2->addField ($rb1);
$r2->addField ($h1);
$r2->addField ($rb2);
$r2->addField ($h2);

```

#### Select - &lt;select&gt;
```php

$s = $form->select ('field-name');
$s->addOptions([
  'o1' => 'Option 1',
  'o2' => 'Option 2',
  'o3' => 'Option 3',
  'o4' => 'Option 4'
]);
$s->required();

```

#### Submit Button - &lt;button&gt; or &lt;input type="submit"&gt;
##### Rendered as a Primary/Submit &lt;button&gt;
```php

$form->submitButton ('field-name')
	->value ('submit')
	->content ('Press me');			// $s->label becomes the content, if the content property is not set.

```

##### Rendered as Secondary &lt;button&gt;
```php

$form->submitButton ('field-name')
	->value ('submit')
	->content ('Press me')
	->renderAsButton();


```

##### Rendered as &lt;input type="submit"&gt;
```php

$form->submitButton ('field-name')
	->value ('submit')
	->label ('Press me')
	->renderAsInput();

```

#### Text - &lt;input type="text"&gt;
```php

$form->text ('field-name');

```

#### Textarea - &lt;textarea&gt;
```php

$form->textarea ('field-name');

```

More fields coming in the future.