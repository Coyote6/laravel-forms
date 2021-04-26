<?php


namespace Coyote6\LaravelForms\Providers;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

use Livewire\Component;


class FormServiceProvider extends ServiceProvider {
	

	/**
	* Register services.
	*
	* @return void
	*/
	public function register() {
		$this->loadViewsFrom (__DIR__ . '/../Resources/views/', 'laravel-forms');
		$this->mergeConfigFrom (__DIR__ . '/../Resources/config/laravel-forms.php', 'laravel-forms');
	}
	
	
	/**
	* Bootstrap services.
	*
	* @return void
	*/
	public function boot() {
	
		$this->publishes([
			__DIR__ . '/../Resources/config/laravel-forms.php' => config_path('laravel-forms.php'),
		], 'laravel-forms');
		
		
		//
		// Blade Components
		//
		$this->configureComponents();
		
		
		//
		// Messaging
		//
		
		Component::macro('notify', function ($message, $status = null) {	
			$this->dispatchBrowserEvent('notify', [
				'text'=> $message, 
				'status' => $status
			]);
		});
		
		Component::macro('notifySuccess', function ($message) {
			$this->dispatchBrowserEvent('notify', [
				'text'=> $message, 
				'status' => 'success'
			]);
		});
		
		Component::macro('notifyWarning', function ($message) {
			$this->dispatchBrowserEvent('notify', [
				'text'=> $message, 
				'status' => 'warning'
			]);
		});
		
		Component::macro('notifyError', function ($message) {
			$this->dispatchBrowserEvent('notify', [
				'text'=> $message, 
				'status' => 'error'
			]);
		});
		
		Component::macro('flash', function ($message, $status) {
			session()->flash('messages', [['text' => $message, 'status' => $status]]);
		});
		
		Component::macro('flashSuccess', function ($message) {
			session()->flash('messages', [['text' => $message, 'status' => 'success']]);
			session()->flash('test', true);
		});
		
		Component::macro('flashWarning', function ($message) {
			session()->flash('messages', [['text' => $message, 'status' => 'warning']]);
		});
		
		Component::macro('flashError', function ($message) {
			session()->flash('messages', [['text' => $message, 'status' => 'error']]);
		});
	
	}
	
	
	/**
     * Configure the Jetstream Blade components.
     *
     * @return void
     */
    protected function configureComponents () {
	    $this->callAfterResolving (BladeCompiler::class, function () {
			
			// 
			// Buttons
			//
			$this->registerComponent ('button');
			$this->registerComponent ('button.link');
			$this->registerComponent ('button.primary');
			$this->registerComponent ('button.secondary');
		
			//
			// Icons 
			//
			$this->registerComponent ('icon.help');
			$this->registerComponent ('icon.error');
			$this->registerComponent ('icon.error.wrapped');

			//
			// Form Items
			//
			$this->registerComponent ('error');
			$this->registerComponent ('label');
			$this->registerComponent ('label.only');
			$this->registerComponent ('input');
			$this->registerComponent ('input.only');
			$this->registerComponent ('textarea');
			$this->registerComponent ('file');
			$this->registerComponent ('textarea');
			$this->registerComponent ('help');
		
		});
    }
  
  
	/**
     * Register the given component.
     *
     * @param  string  $component
     * @return void
     */
    protected function registerComponent (string $component) {
		Blade::component ('laravel-forms::components.' . $component, 'forms-' . $component);
    }
  
}
