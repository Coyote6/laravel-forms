<?php
	

namespace Coyote6\LaravelForms\Livewire;


use Livewire\Component;
use Livewire\WithPagination;


abstract class Crud extends Component {
	
	
	use WithPagination;
	
	
	protected $resultsPerPage = 5;
	
	
	public function template () {
		$template = 'livewire.forms.form';
		if (!view()->exists ($template)) {
			$template = 'laravel-forms::' . $template;
		}
		return $template;
	}
	
	public function rules () {
		return $this->searchForm()->lwRules();
	}
	
	public function updated ($field) {
		$this->validateOnly ($field);
	}
	
	
	protected function templateForms () {
		return = [
			'searchForm' => $this->searchForm(),
			'createForm' => $this->createForm(),
			'updateForm' => $this->updateForm(),
			'deleteForm' => $this->deleteForm(),
		];
	}
	
	public function render () {
		$vars = array_merge($this->templateForms(), $this->templateVars());
		return view ($this->template(), $vars);
	}
	
	/**
     * Returns a Coyote6\LaravelForms\Form\Form instance.
     *
     * @return Form
     */
    abstract protected function searchForm ();
    abstract protected function createForm ();
    abstract protected function updatedForm ();
    abstract protected function deleteForm ();
	
}