<?php
	
	
namespace Coyote6\LaravelForms\Traits;


use Coyote6\LaravelForms\Form\Autofill;
use Coyote6\LaravelForms\Form\Button;
use Coyote6\LaravelForms\Form\Checkbox;
use Coyote6\LaravelForms\Form\Date;
use Coyote6\LaravelForms\Form\Email;
use Coyote6\LaravelForms\Form\Field;
use Coyote6\LaravelForms\Form\FieldGroup;
use Coyote6\LaravelForms\Form\File;
use Coyote6\LaravelForms\Form\Form;
use Coyote6\LaravelForms\Form\Hidden;
use Coyote6\LaravelForms\Form\Html;
use Coyote6\LaravelForms\Form\Image;
use Coyote6\LaravelForms\Form\LivewireComponent;
use Coyote6\LaravelForms\Form\Number;
use Coyote6\LaravelForms\Form\Password;
use Coyote6\LaravelForms\Form\Radio;
use Coyote6\LaravelForms\Form\Radios;
use Coyote6\LaravelForms\Form\Select;
use Coyote6\LaravelForms\Form\SubmitButton;
use Coyote6\LaravelForms\Form\Textarea;
use Coyote6\LaravelForms\Form\Text;


trait AddFields {


	protected $fields = [];


	public function addField (Field $field) {

		if (
			$field instanceof Radio &&
			(!$this instanceof Radios || !$this instanceof FieldGroup)
		) {
			
			$fieldGroup = Radios::get($field->name);
			$fieldGroup->addField($field);
			$fieldGroup->parent = $this;
			$fieldGroup->cache = $this->cache;
			$fieldGroup->id = Form::uniqueId ($fieldGroup->parent->id, $fieldGroup->name);
			$fieldGroup->theme = $this->theme;

			if ($fieldGroup->parent instanceof Form) {
				$fieldGroup->form = $fieldGroup->parent;
			}
			else {
				$fieldGroup->form = $fieldGroup->parent->form;
			}
			
			$fieldGroup->init();
			$this->fields[$fieldGroup->name] = $fieldGroup;
			
		}
		else {
			
			$field->cache = $this->cache;
			$field->parent = $this;
			$field->id = Form::uniqueId ($field->parent->id, $field->name);
			$field->theme = $this->theme;
			if ($field->parent instanceof Form) {
				$field->form = $field->parent;
			}
			else {
				$field->form = $field->parent->form;
			}

			$field->init();
			
			if (!$field instanceof Radio) {
				$this->fields[$field->name] = $field;

			}
			else {
				$this->fields[$field->name . '--' . $field->value] = $field;
			}
		}
		return $this;
	}
	
	
	public function addFieldGroup (FieldGroup $fieldGroup) {
		$fieldGroup->parent = $this;
		$fieldGroup->id = Form::uniqueId ($fieldGroup->parent->id, $fieldGroup->name);
		$fieldGroup->cache = $this->cache;
		$fieldGroup->theme = $this->theme;
		if ($fieldGroup->parent instanceof Form) {
			$fieldGroup->form = $fieldGroup->parent;
		}
		else {
			$fieldGroup->form = $fieldGroup->parent->form;
		}

		$fieldGroup->init();
		$this->fields[$fieldGroup->name] = $fieldGroup;
		
		return $this;
	}
	
	
	public function autofill ($name) {
		$field = new Autofill ($name);
		$this->addField ($field);
		return $field;
	}
	
	
	public function button ($name) {
		$field = new Button ($name);
		$this->addField($field);
		return $field;
	}
	
	public function checkbox ($name) {
		$field = new Checkbox ($name);
		$this->addField($field);
		return $field;
	}
	
	public function date ($name) {
		$field = new Date ($name);
		$this->addField($field);
		return $field;
	}
	
	public function email ($name) {
		$field = new Email ($name);
		$this->addField ($field);
		return $field;
	}
	
	public function fieldGroup ($name) {
		$field = new FieldGroup ($name);
		$this->addFieldGroup($field);
		return $field;
	}
	
	public function file ($name) {
		$field = new File ($name);
		$this->addField($field);
		return $field;
	}
	
	public function files ($name) {
		$field = $this->file ($name);
		$field->addAttribute ('multiple', true);
		return $field;
	}
	
	public function hidden ($name) {
		$field = new Hidden ($name);
		$this->addField($field);
		return $field;
	}
	
	public function html ($name) {
		$field = new Html ($name);
		$this->addField($field);
		return $field;
	}
	
	public function image ($name) {
		$field = new Image ($name);
		$this->addField ($field);
		return $field;
	}
	
	public function images ($name) {
		$field = $this->image ($name);
		$field->addAttribute ('multiple', true);
		return $field;
	}
	
	public function livewireComponent ($name) {
		$field = new LivewireComponent ($name);
		$this->addField ($field);
		return $field;
	}
	
	
	public function number ($name) {
		$field = new Number ($name);
		$this->addField($field);
		return $field;
	}
	
	public function password ($name) {
		$field = new Password ($name);
		$this->addField ($field);
		return $field;
	}

	public function radios ($name) {
		$fieldGroup = new Radios ($name);
		$this->addFieldGroup ($fieldGroup);
		return $fieldGroup;
	}
	
	public function select ($name) {
		$field = new Select ($name);
		$this->addField($field);
		return $field;
	}
	
	public function string ($name) {
		return $this->text ($name);
	}
	
	public function submitButton ($name) {
		$field = new SubmitButton ($name);
		$this->addField($field);
		return $field;
	}
	
	public function text ($name) {
		$field = new Text ($name);
		$this->addField($field);
		return $field;
	}
	
	public function textarea ($name) {
		$field = new Textarea ($name);
		$this->addField($field);
		return $field;
	}
	
	public function textfield ($name) {
		return $this->text ($name);
	}
	
	
	public function fields () {
		return $this->fields;
	}
	
	
	protected function flattenFields ($fields) {
		$flatten = [];
		foreach ($fields as $f) {
			if (is_callable ([$f, 'fields'])) {
				$flatten[] = $f;
				foreach ($this->flattenFields ($f->fields()) as $child) {
					$flatten[] = $child;
				}
			}
			else {
				$flatten[] = $f;
			}
		}
		return $flatten;
	}
	
	
	protected function sortFields () {
		$toSort = [];
		$orderAdded = 0;
		foreach ($this->fields as $name => $field) {
			$orderAdded++;
			$toSort[] = [
				'name' => $name,
				'weight' => $field->weight,
				'field' => $field,
				'order-added' => $orderAdded
			];
		}
	
		$collection = collect ($toSort);
		$sorted = $collection->sortBy([
			['weight','asc'],
			['order-added','asc'],
		])->mapWithKeys(function ($item) {
			return [$item['name'] => $item['field']];
		});
		
		return $sorted;
	}
	
	
	public function getField (string $name) {
		if (isset ($this->fields[$name])) {
			return $this->fields[$name];
		}
		return false;
	}
	
	
	public function keyedFields () {
		$flat = $this->flattenFields ($this->fields);
		$keyed = [];
		foreach ($flat as $f) {
			$keyed[$f->name] = $f;
		}
		return $keyed;
	}
	
	
	public function findField (string $name) {
		$keyed = $this->keyedFields();
		if (isset ($keyed[$name])) {
			return $keyed[$name];
		}
		return false;
	}
	
	
	public function find (string $name) {
		return $this->findField ($name);
	}
	
}

