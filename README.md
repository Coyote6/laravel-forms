# Laravel Forms

## About The Project
Laravel Forms is just a simple class used to generate the html for forms and assist with simple validation process in Laravel.  This project is still in development, so documentation will be slow going.

## Prerequisites
* PHP 7.2 or Higher
* Laravel Install

## Getting Started
1. Install via composer:
```sh
composer require Coyote6/laravel-forms
```
2. Copy the config file to your config folder.
```sh
php artisan vendor:publish --tag=laravel-forms
```

## To Use

### Basic Example
#### In the controller file
```php
use Coyote6\LaravelForms\Form\Form;

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


### Use with Livewire
#### In the your base app blade template, below where you call @livewireScripts, add a stack('scripts') call if you haven't already done so.
```php
@stack('scripts')
```

#### In the component
```php
 
namespace App\Http\Livewire;
 
use Livewire\Compoent;
use Coyote6\LaravelFroms\Form\Form;
 
class Example extends Component {
	 
	 
	public $email = '';
	public $password = '';
	public $passwordConfirmation = '';
	
	
	protected function rules() {
    return $this->form()->lwRules(); // lwRules() is an alias to livewireRules()
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
		return ['success' => $values;
	}
	
	
	public function form () {
		
		$form = new Form ($this); 	// Sets up the form as a Livewire form... alternatively you can call $form->isLivewireForm($this);	
		$form->action = '/store';		// Optional fallback in case someone shuts off Javascript
	  $form->method('POST');
		$form->addAttribute ('wire:submit.prevent', 'store');
		
		$e = $form->email ('email');
		$e->label = 'Email';
		$e->livewireModel ('email');
		$e->required();
		$e->addRule('unique:users');
		
		$p = $form->password ('password');
		$p->label = 'Password';
		$p->lwModel ('password'); // Alias to livewireModel() method
		$p->addRule ('min:6');
		
		$pc = $p->confirm();
		$pc->label = 'Confirm Password';
		$pc->lwModelLazy ('passwordConfirmation'); // Use livewireModelLazy(), lwModelLazy(), lwLazy() to call wire:model.lazy 
		
		//
		// Use getLivewireModel(), getLwModel(), getLw() methods to retrieve the Livewire model name.
		// $pc->getLw();
		//
		
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
You must already have tailwind installed and configured.
#### In the .env File
```
FORM_THEME=tailwind
```
Some classes are added to items automatically.  You can shut them off by using:
```
FORM_DEFAULT_CLASSES=false
```
If you wish to change the default tailwind classes, you can change the config/laravel-forms.php file.  The default classes are stored under the tailwind section.  Additional styling options are set in there as well.

### Available Fields (More to come)
#### Button - &lt;button&gt;
```php

$b = $form->button ('field-name');
$b->value = 'Button Value';		// Is the default button content unless the content property is set.
$b->content = 'This is what shows inside the button';

```

#### Checkbox - &lt;input type="checkbox"&gt;
```php

$c = $form->checkbox ('field-name');
$c->value = 'Value when submitted';	
$c->label = 'Click me';
```

#### Email - &lt;input type="email"&gt;
##### Simple Email
```php

$e = $form->email ('field-name');

```

##### Email w/ Confirmation
```php

$e = $form->email ('field-name');
$e->label = 'Email';
$ec = $e->confirm();
$ec->label = 'Confirm Email';

```

#### Field Group - &lt;div&gt;
This just wraps a group of fields.  It can have a label, if desired.
```php

$fg = $form->fieldGroup ('field-name');
$fg->label = 'Contact Info';
```

#### File - &lt;input type="file"&gt; (Untested at the moment)
```php

$f = $form->file ('field-name');
$f->label = 'Upload File';
```

#### Hidden - &lt;input type="hidden"&gt;
```php

$h = $form->hidden ('field-name');
$h->value = 'some value';
```

#### Html - &lt;div&gt; 
```php

$h = $form->html ('field-name');
$h->content = '<em>Custom Html Field</em>';
```

#### Image - &lt;input type="file"&gt; (Untested at the moment)
```php

$i = $form->image ('field-name');
$i->label = 'Upload Image';
```

#### Number - &lt;input type="number"&gt;
```php

$n = $form->number ('field-name');
$n->label = 'Enter Your Lucky Number';
```

#### Password - &lt;input type="password"&gt;
##### Simple Password
```php

$p = $form->password ('field-name');
$p->label = 'Password';
```

##### Password w/ Confirm
```php

$p = $form->password ('field-name');
$p->label = 'Password';
$pc = $p->confirm();
$pc->label = 'Password Confirm';
```

#### Radio Buttons - &lt;input type="radio"&gt;
##### Simple Radio Button
```php

$r1 = $form->radios ('field-name');
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

$r2 = $form->radios ('field-name');
$r2->required();
$r2->value = 'o1';  // Set a default value
	    
$rb1 = new Radio ('field-name');
$rb1->label = 'Option 1';
$rb1->value = 'o1';
	    
$h1 = new Html ('field-name--html-1');
$h1->value = 'Cool HTML info about option 1';
	    
$rb2 = new Radio ('field-name');
$rb2->label = 'Option 2';
$rb2->value = 'o2';

$h2 = new Html ('field-name--html-2');
$h2->value = 'Cool HTML info about option 2';

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
##### Rendered as &lt;button&gt;
```php

$s = $form->submitButton ('field-name');
$s->value = 'submit';
$s->content = 'Press me';			// $s->label becomes the content, if the content property is not set.

```

##### Rendered as &lt;input type="submit"&gt;
```php

$s = $form->submitButton ('field-name');
$s->value = 'submit';
$s->label = 'Press me';
$s->renderAsInput();

```

#### Text - &lt;input type="text"&gt;
```php

$t = $form->text ('field-name');
```

#### Textarea - &lt;textarea&gt;
```php

$ta = $form->textarea ('field-name');
```