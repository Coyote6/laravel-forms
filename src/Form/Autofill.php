<?php


namespace Coyote6\LaravelForms\Form;


use Coyote6\LaravelForms\Form\Input;
use Illuminate\Database\Eloquent\Model;
use Exception;


class Autofill extends Input {
	

	protected $type = 'autofill';
	protected $template = 'autofill';
	
	protected $table;
	protected $idField;
	protected $nameField = 'name';
	protected $searchFields = 'name';
	protected $sortFields = 'name';
	protected $multiFieldSearch = false;
	protected $searchClass;
	protected $selectionsAllowed = 0;	// 0 = infinite
	protected $exclude;
	
	protected $searchProperty;
	protected $prevSearchProperty;
	protected $suggestedProperty;
	protected $selectedProperty;
	protected $selectedMethod;
	protected $removeMethod;
	
	protected $search = '';
	protected $isSameAsLastSearch = false;
	
	protected $lwProp;
	protected $lwModel;
	
	public $maxSelectionsMessage = 'No more selections are allowed.';
	public $noResultsMessage = 'Sorry, no results were found.';
	public $noSearchResultsMessage = 'Sorry, no results were found for your search.';
	public $noMoreResultsMessage = 'No more results were found.';
	public $noMoreCurrentResultsMessage = 'No more results were found for the current search.';
	
	
	//
	// Methods to call from Lw
	//
	
	//
	// public $examples = [];
	// public $examplesSearch = '';
	// public $examplesPrevSearch = '';
	// public $examplesSuggested = [];
	//
	// protected function examplesField () {
	//	return $this->form()->find('examples');
	// }
	//
	// public function updatedRolesSearch ($value) {
	//	$this->examplesField()->findSuggestions (User::class, $value);
	// }
	//
	// public function autofillSelectedExamples ($id, $name) {
	//	$this->examplesField()->select ($id, $name);
	// }
	//
	// public function autofillRemoveExamples ($id) {
	//	$this->examplesField()->remove ($id);
	// }
	//
	
	public function search ($value) {

		$lw = $this->getComponent();
		if (is_null ($this->searchClass)) {
			$lw->addError ($this->name, 'The field is misconfigured, and the search cannot be called. Please make sure to call ->searchClass($class) method on the Autofill field and that the class extends Illuminate\Database\Eloquent\Model.');
			return;
		}
		
		if ($this->selectionsAllowed == 1) {
			return $this->singleSearch ($value);
		}
		return $this->multiSearch ($value);
			
	}
	
	
	protected function singleSearch ($value) {
		
		$lw = $this->getComponent();

		// Stop the selection if no more are allowed.
		if (is_string ($lw) && $lw != '') {
			$lw->addError ($this->name, $this->maxSelectionMessage);
			return;
		}
		
		$values = $this->searchValues ($value);
		
		$selected = $this->getSelected();
		$suggestedProp = $this->setComponentProperty ($this->suggestedProperty, []);
		
		$suggestedProp = $this->setComponentProperty ($this->suggestedProperty, []);
		foreach ($values as $v) {
			if ($selected != $v->getKey()) {
				$suggestedProp[$v->getKey()] = $v->{$this->nameField};
			}
		}
		$this->setComponentProperty ($this->suggestedProperty, $suggestedProp);

	}
	
	protected function multiSearch ($value) {
		
		$lw = $this->getComponent();

		// Stop the selection if no more are allowed.
		if (is_array ($lw) && count ($lw) >= $this->selectionsAllowed) {
			$lw->addError ($this->name, $this->maxSelectionMessage);
			return;
		}

		$values = $this->searchValues ($value);
		$selected = $this->getSelected();
		
		$suggestedProp = $this->setComponentProperty ($this->suggestedProperty, []);
		foreach ($values as $v) {
			if (!isset ($selected[$v->getKey()])) {
				$suggestedProp[$v->getKey()] = $v->{$this->nameField};
			}
		}
		$this->setComponentProperty ($this->suggestedProperty, $suggestedProp);

	}
	
	
	protected function searchValues ($value) {
		if ($value == '') {
			return $this->searchClass::query ()
				->exclude($this->idField, $this->exclude)
				->multiFieldSort($this->sortFields)
				->get();
		}
		if ($this->multiFieldSearch) {
			return $this->searchClass::query ()
				->exclude($this->idField, $this->exclude)
				->multiFieldSearch($this->searchFields, $value)
				->multiFieldSort($this->sortFields)
				->get();
		}
		
		return $this->searchClass::query ()
			->exclude($this->idField, $this->exclude)
			->search($this->searchFields, $value)
			->multiFieldSort($this->sortFields)
			->get();
		
	}
	
	
	public function select (string $id, string $name) {
		if ($this->selectionsAllowed == 1) {
			return $this->singleSelect ($id, $name);
		}
		return $this->multiSelect ($id, $name);
	}

	
	
	protected function singleSelect (string $id, string $name) {

		// Model
		$lw = $this->getSelected();
		
		// Stop the selection if no more are allowed.
		if (is_string ($lw) && $lw != '') {
			return;
		}
		
		// Get the object.
		$obj = $this->searchClass::find ($id);
		if (!is_null ($obj)) {
			$lw = $id;
		}

		$this->setSelected ($lw);
		$this->setSelectionProperties ($id, $name);
		$this->getComponent()->form(true);

	}
	
	
	protected function multiSelect (string $id, string $name) {

		// Model
		$lw = $this->getSelected();
		if (is_null ($lw)) {
			$lw = [];
		}
		
		// Stop the selection if no more are allowed.
		if (is_array ($lw) && $this->selectionsAllowed !== 0 && count ($lw) >= $this->selectionsAllowed) {
			return;
		}
		
		// Get the object.
		$obj = $this->searchClass::find ($id);
		if (!is_null ($obj)) {
			$lw += [$id => $id];
		}
		$this->setSelected ($lw);
		$this->setSelectionProperties ($id, $name);
		$this->getComponent()->form(true);
	
	}
	
	
	protected function setSelectionProperties (string $id, string $name) {
		
		// Selected
 		$selectedProperty = $this->getComponentProperty ($this->selectedProperty);
		if (is_null ($selectedProperty)) {
			$selectedProperty = $this->setComponentProperty ($this->selectedProperty, []);
		}
		$selectedProperty += [$id => $name];
		$this->setComponentProperty ($this->selectedProperty, $selectedProperty);
		
		
		// Suggested
		$suggestedProp = $this->getComponentProperty ($this->suggestedProperty);
		if (is_null ($suggestedProp)) {
			$suggestedProp = $this->setComponentProperty ($this->suggestedProperty, []);
		}
		if (isset ($suggestedProp[$id])) {
			unset ($suggestedProp[$id]);
		}
		$this->setComponentProperty ($this->suggestedProperty, $suggestedProp);

		// Attempt to run updated selected property.
		$comp = $this->getComponent();
		$updatedSelectedMethod = 'updated' . ucfirst ($this->selectedProperty);
		if (method_exists ($comp, $updatedSelectedMethod)) {
			$comp->$updatedSelectedMethod ($selectedProperty);
		}
	
	}
	
	
	public function remove (string $id) {
		
		$lw = $this->getComponentProperty ($this->lwModel);
		$selected = $this->getSelected();
		
		if ($this->selectionsAllowed == 1) {
			if ($lw == $id) {
				$lw = null;
			}
		}
		else {
			if (isset ($selected[$id])) {
				unset ($selected[$id]);
				if (is_string ($this->lwProp)) {
					$lw->{$this->lwProp} = $selected;
				}
				else {
					$lw = $selected;
				}
				
			}
		}
		$this->setComponentProperty ($this->lwModel, $lw);
		
		$selectedProperty = $this->getComponentProperty ($this->selectedProperty);
		if (isset ($selectedProperty[$id])) {
			unset ($selectedProperty[$id]);
		}
		$this->setComponentProperty ($this->selectedProperty, $selectedProperty);
		
		$updatedMethod = 'updated' . ucfirst ($this->searchProperty);
		$currentValue = $this->getComponentProperty ($this->searchProperty);
		$comp = $this->getComponent();
		$comp->$updatedMethod ($currentValue);
		
		// Attempt to run updated selected property.
		$updatedSelectedMethod = 'updated' . ucfirst ($this->selectedProperty);
		if (method_exists ($comp, $updatedSelectedMethod)) {
			$comp->$updatedSelectedMethod ($selectedProperty);
		}
		
		// Attempt to run updated property.
		$updatedLwMethod = 'updated' . ucfirst ($this->lwModel);
		if (method_exists ($comp, $updatedLwMethod)) {
			$comp->$updatedLwMethod ($lw);
		}
		
	}
	
	
	//
	// Table Setup
	//

	
	public function autofillTable (string $table, string $idField = 'id') {
		
		if ($this->getLw() == '') {
			$this->lwDebounce();	
		}
		
		$this->table = $table;
		$this->idField = $idField;
	
		
		return $this;
	}
	

	public function table (string $table, string $idField = 'id') {
		return $this->autofillTable ($table, $idField);
	}
	
	
	//
	// Search Class Setup
	//
	public function searchClass (string $class) {

		$is_string = is_string ($class);
		$is_obj = is_object ($class);
		
		if ((!$is_string && !$is_obj) || ($is_obj && !$class instanceof Model) || !is_callable ([$class, 'query'])) {
			trigger_error ('The field is misconfigured, and the search cannot be called. Please make sure that the class extends Illuminate\Database\Eloquent\Model.');
		}
		
		if (is_object($class)) {
			$class = get_class ($class);
		}
		$this->searchClass = $class;
		
		return $this;
		
	}
	
	
	
	//
	// Property Setup
	//
	
	public function searchProperty (string $name = null) {
		if (is_string ($name) && $name != '') {
			$this->searchProperty = $name;
		}
		return $this;
	}
	
	
	public function prevSearchProperty (string $prevSearchProperty = null) {
		if (is_string ($name) && $name != '') {
			$this->prevSearchProperty = $name;
		}
		return $this;
	}
	
	
	public function suggestedProperty (string $name = null) {
		if (is_string ($name) && $name != '') {
			$this->suggestedProperty = $name;
		}
		return $this;
	}
	
	
	public function selectedMethod (string $name = null) {
		if (is_string ($name) && $name != '') {
			$this->selectedMethod = $name;
		}
		return $this;
	} 
	
	
	public function removeMethod (string $name = null) {
		if (is_string ($name) && $name != '') {
			$this->removeMethod = $name;
		}
		return $this;
	} 
		
	
	public function idField (string $name) {
		if ($name != '') {
			$this->idField = $name;
		}
		return $this;
	}
	
	
	public function nameField (string $name) {
		if ($name != '') {
			$this->nameField = $name;
		}
		return $this;
	}
	
	
	//
	// @param $fields - string or array
	//		As a string:
	//			'field'
	//			'field,field2,field3'
	//
	//		As an array:
	//			['field']
	//			['field','field2','field3']
	//
	public function searchFields ($fields) {
		
		if (is_string ($fields) && $fields != '') {
			$fields = explode(',', $fields);
			foreach ($fields as &$f) {
				$f = trim($f);
			}
		}
		
		if (is_array ($fields)) {
			if (count ($fields) > 0) {
				$this->multiFieldSearch = true;
				$this->searchFields = $fields;
			}
			else {
				$this->searchFields = current ($fields);
			}
		}
		
		return $this;
	}
	
	
	//
	// @param $fields - string or array
	//
	//		As a string:
	//			'field'
	//			'field:asc'
	//			'field,field2'
	//			'field:asc,field2:desc'
	//
	//		As an array:
	//			['field:asc']
	//			['field' => 'asc']
	//			['field:asc', 'field2:desc']
	//			['field'=>'asc', 'field2'=>'desc']
	//
	public function sortFields ($fields) {
		
		if ((is_string ($fields) && $fields != '') || is_array ($fields)) {
			$this->sortFields = $fields;
		}
	
		return $this;
	}
	
	
	public function noResultsMessage (string $message) {
		if ($message != '') {
			$this->noResultsMessage = $message;
		}
		return $this;
	}
	
	
	public function noMoreResultsMessage (string $message) {
		if ($message != '') {
			$this->noMoreResultsMessage = $message;
		}
		return $this;
	}
	
	//
	// Set to 0 for infinite
	//
	public function selectionsAllowed (int $number) {
		$this->selectionsAllowed = $number;	
		return $this;
	}
	
	public function singleSelection () {
		return $this->selectionsAllowed(1);
	}
	
	public function single () {
		return $this->selectionsAllowed(1);
	}
	
	
	public function exclude ($ids) {
		$this->exclude = $ids;
		return $this;
	}
	
	
	
	//
	// Rules
	//
	
	public function rules () {
		if (!isset ($this->rules['exists'])) {
			$this->rules['exists'] = 'exists:' . $this->table . ',' . $this->idField;
		}
		if ($this->selectionsAllowed != 1) {
			$this->rules['array'] = 'array';
		}
		return $this->rules;
	}
	
	
	//
	// Lw
	//
	
	public function livewireModel (string $name = null) {
		parent::livewireModel ($name);
		$this->setProperties();
		$this->addAttribute ('wire:model', $this->searchProperty);
		return $this;
	}
	
	
	public function livewireModelLazy (string $name = null) {
		parent::livewireModelLazy ($name);
		$this->setProperties();
		$this->addAttribute ('wire:model.lazy', $this->searchProperty);
		return $this;
	}
	

	public function livewireModelDebounce (string $name = null, int $milliseconds = 750) {
		parent::livewireModelDebounce ($name, $milliseconds);
		$this->setProperties();
		$this->addAttribute ('wire:model.debounce.' . $milliseconds . 'ms', $this->searchProperty);
		return $this;
	}
	
	
	public function setProperties () {
		
		$lwModelProp = $this->getLw();
		if (strpos ($lwModelProp, '.') !== false) {
			$modelProp = explode ('.', $lwModelProp);
			$this->lwModel = $modelProp[0];
			$lwProp = $this->lwProp = $modelProp[1];
		}
		else {
			$lwProp = $this->lwModel = $lwModelProp;
		}
		
		$this->searchProperty = $lwProp . 'Search';
		$this->prevSearchProperty = $lwProp . 'PrevSearch';
		$this->suggestedProperty = $lwProp . 'Suggested';
		$this->selectedProperty = $lwProp . 'Selected';
		$this->selectedMethod = 'autofillSelected' . ucfirst ($lwProp);
		$this->removeMethod = 'autofillRemove' . ucfirst ($lwProp);
		
		$searchProp = $this->getComponentProperty ($this->searchProperty);
		if (is_null ($searchProp)) {
			$this->setComponentProperty ($this->searchProperty, '');
		}
		
		$prevProp = $this->getComponentProperty ($this->prevSearchProperty);
		if (is_null ($prevProp)) {
			$this->setComponentProperty ($this->prevSearchProperty, '');
		}
		
		$suggestedProp = $this->getComponentProperty ($this->suggestedProperty);
		if (is_null ($suggestedProp)) {
			$this->setComponentProperty ($this->suggestedProperty, []);
		}
		
		$selectedProp = $this->getComponentProperty ($this->selectedProperty);
		if (is_null ($selectedProp)) {
			$this->setComponentProperty ($this->selectedProperty, []);
		}
		
	}
	
	
	//
	// Get/Set Selected
	//
	public function getSelected () {
		$lw = $this->getComponentProperty($this->lwModel);
		if (is_string ($this->lwProp)) {
			return $lw->{$this->lwProp};
		}
		else {
			return $lw;
		}
	}
	
	
	public function setSelected ($value) {
		$lw = $this->getComponentProperty($this->lwModel);
		if (is_string ($this->lwProp)) {
			$lw->{$this->lwProp} = $value;
		}
		else {
			$lw = $value;
		}
		$val = $this->setComponentProperty($this->lwModel, $lw);

		// Attempt to run updated property.
		$comp = $this->getComponent();
		$updatedLwMethod = 'updated' . ucfirst ($this->lwModel);
		if (method_exists ($comp, $updatedLwMethod)) {
			$comp->$updatedLwMethod ($lw);
		}
		
		return $val;
	}
	
	
	//
	// Config Validation
	//
	protected function checkConfig () {
		
		$lw = $this->getComponent();
		
		if (is_null ($lw)) {
			throw new Exception ('Please be sure the form, is a Livewire form in order to use the Autofill field.');
		}

		// Table
		if (is_null ($this->table) || $this->table == '') {
			throw new Exception ('The "' . $this->name . '" autofill field is misconfigured. Please be sure to call $field->table() to set the database table needed for the query.');
		}
		
		// Class

		if (!is_null ($this->searchClasss)) {
			throw new Exception ('The "' . $this->name . '" autofill field is misconfigured. Please make sure to call $field->searchClass() to set the class to search on and that the class extends Illuminate\Database\Eloquent\Model.');
		}	

		// Main Livewire - Selected Property
		if (is_string ($this->lwProp)) {
			if (!property_exists ($lw, $this->lwModel)) {
				throw new Exception ('The "' . $this->name . '" autofill field is misconfigured. Please make sure the "' . $this->lwModel . '" property exists on the Livewire component, is public, and is an object with the "' . $this->lwProp . '" property.');
			}
		}
		else if (
			!property_exists ($lw, $this->lwModel) || 
			($this->selectionsAllowed != 1 && !is_array ($lw->{$this->lwModel})) || 
			($this->selectionsAllowed == 1 && !is_null ($lw->{$this->lwModel}) && !is_string ($lw->{$this->lwModel}))
		) {
			throw new Exception ('The "' . $this->name . '" autofill field is misconfigured. Please make sure the "' . $this->lwModel . '" property exists on the Livewire component, is public, and is an array if more than one selection is allowed or null or a string if only one selection is allowed.');

		}

	
		// Search Method
		if (!method_exists ($lw, 'updated' . ucfirst ($this->searchProperty))) {
			throw new Exception ('The "' . $this->name . '" autofill field is misconfigured. Please make sure the "updated' . ucfirst ($this->searchProperty) . ' ($value)" method exists on the Livewire component and calls $this->form()->find("' . $this->name . '")->search ($class, $value).');
			
		}
		
		// Selected Method
		if (!method_exists($lw, $this->selectedMethod)) {
			throw new Exception ('The "' . $this->name . '" autofill field is misconfigured. Please make sure the "' . $this->selectedMethod . ' ($id, $name)" method exists on the Livewire component and calls $this->form()->find("' . $this->name . '")->select ($id, $name).');
		}
		
		// Remove Method
		if (!method_exists($lw, $this->removeMethod)) {
			throw new Exception ('The "' . $this->name . '" autofill field is misconfigured. Please make sure the "' . $this->removeMethod . ' ($id)" method exists on the Livewire component and calls $this->form()->find("' . $this->name . '")->remove ($id).');
		}
		
		// Exclude
		if (!is_null ($this->exclude) && !is_string ($this->exclude) && !is_array ($this->exclude)) {
			throw new Exception ('The "' . $this->name . '" autofill field is misconfigured. Please make sure the exclude() value is a string or array of ids to exclude from the search.');

		}
		
	}
	
	
	//
	// Rendering
	//
	
	protected function prerender () {
		
		if ($this->getLw() == '') {
			$this->lwDebounce();
		}

		$this->checkConfig();
		
		$searchProp = $this->getComponentProperty ($this->searchProperty);
		$prevSearchProp = $this->getComponentProperty ($this->prevSearchProperty);
	
		$this->search($searchProp);
		$this->search = $searchProp;
		$this->isSameAsLastSearch = ($this->search === $prevSearchProp);
		$this->setComponentProperty ($this->prevSearchProperty, $this->search);
		
		parent::prerender();
		
		$this->addAttribute ('autocomplete', 'off');
		
		$this->fieldContainerTag()
			->addAttribute ('x-data','{showSuggestions: false}')
			->addAttribute ('@click.away', 'showSuggestions = false');
	
	}
	
	
	public function templateVariables () {
							
		$vars = parent::templateVariables();
		$lw = $this->getComponent();
		
		$suggestedProp = $this->getComponentProperty ($this->suggestedProperty);
		if (is_null ($suggestedProp)) {
			$this->setComponentProperty ($this->suggestedProperty, []);
		}
		
		$selectedProp = $this->getComponentProperty ($this->selectedProperty);
		if (is_null ($selectedProp)) {
			$this->setComponentProperty ($this->selectedProperty, []);
		}
		
		if ($this->selectionsAllowed !== 0 && count ($selectedProp) >= $this->selectionsAllowed) {
			$this->disable();
			$vars['attributes'] = $this->renderAttributes();
			
		}

		$vars += [
			'suggestions' =>  $suggestedProp,
			'selected_method' => $this->selectedMethod,
			'selected' => $selectedProp,
			'remove_method' => $this->removeMethod,
			'search' => $this->search,
			'sameSearch' => $this->isSameAsLastSearch,
			'selectionsAllowed' => $this->selectionsAllowed,
			'max_selections_message' => $this->maxSelectionsMessage,
			'no_results_message' => $this->noResultsMessage,
			'no_more_results_message' => $this->noMoreResultsMessage,
			'no_search_results_message' => $this->noSearchResultsMessage,
			'no_more_current_results_message' => $this->noMoreCurrentResultsMessage
		];
	
		
		return $vars;		
		
	}
	
	
}
