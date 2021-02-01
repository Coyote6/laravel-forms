# Laravel Forms

## About The Project
Laravel Forms is just a simple class used to generate the html for forms and assist with simple validation process in Laravel.  This project is still in development, so documentation will be slow going.

## Prerequisites
* Composer
* PHP 7.2 or Higher
* Laravel Install

## Getting Started
1. Installation process is still being developed.  Eventually it will be installed via composer:
```sh
composer require Coyote6/laravel-forms
```

## To Use

### Basic Example
#### In the controller file
```php
use Coyote6\LaravelForms\Form;

$form = new Form();
$field1 = $form->text('field-name--1');	
$field1->addRule ('min', '5');
$field1->label = 'Field 1';
$field1->required();
$field2 = $form->textArea ('field-name--2');
$field2->label = 'Field 2';
```
#### In Blade Template
``` PHP
{{ $form }}
```

### Best Practice
For best use it is recommended to set up the form in the controller under its own private/protected method, so that it may be reused for validation.

#### In the controller file
```php

namespace App\Http\Controllers;

use Coyote6\LaravelForms\Form;
use Illuminate\Http\Request;


class HomeController extends Controller  {
	
	
	protected function form () {

		$form = new Form();
		$form->action = '/home';
		$form->method = 'POST';
		
		$field1 = $form->email('email');	
		$field1->addAttribute ('placeholder', 'Please, Enter Your Email Address');
		$field1->required();
		
		$field2 = $form->checkbox ('tos');
		$field2->label = 'You must agree to our ToS.';
		$field2->required();
		
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
$form->action = '/home';
$form->method = 'PUT';

$u = $form->username ('username');
$u->required();
$u->addRules (['min:8', 'max:255', 'unique:users']); // Add laravel validation rules as an array.

$e = $form->email ('email');
$e->required();
$e->addRule ('max:255'); // Add laravel validation rules individually
$e->addRule ('unique', 'users');
$ec = $e->confirm();  // Automatically adds extra confirm field and validates it.

$p = $form->password ('password');	
$p->required();
$p->addRules (['min:5', 'max:255']]);
$p->removeRule ('max');  // Remove rules by their name
$p->confirm();

// Default submit button gets automatically added, unless told otherwise.
if (isset ($_POST['submit'])) {
	$validatedData = $form->validate();
	return $validatedData;
}
```

### Available Fields (More to come)
#### Radio Buttons
##### Simple Radio Button
```php

$r1 = $form->radios ('radio-1');
$r1->label = "Please select an option";
$r1->addOptions([
  'o1' => 'Option 1',
  'o2' => 'Option 2',
  'o3' => 'Option 3',
  'o4' => 'Option 4'
]);
$r1->required();

```

##### Radio Buttons with HTML
```php

$r2 = $form->radios ('radio-2');
$r2->required();
$r2->value = 'o1';  // Set a default value
	    
$rb1 = new Radio ('radio-2');
$rb1->label = 'Option 1';
$rb1->value = 'o1';
	    
$h1 = new Html ('h1');
$h1->value = 'Cool HTML info about option 1';
	    
$rb2 = new Radio ('radio-2');
$rb2->label = 'Option 2';
$rb2->value = 'o2';

$h2 = new Html ('h2');
$h2->value = 'Cool HTML info about option 2';

$r2->addField ($rb1);
$r2->addField ($h1);
$r2->addField ($rb2);
$r2->addField ($h2);

```

