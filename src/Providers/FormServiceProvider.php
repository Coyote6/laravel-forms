<?php


namespace Coyote6\LaravelForms\Providers;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

use Livewire\Component;


require __DIR__ . '/../Helpers/Aliases.php';


class FormServiceProvider extends ServiceProvider {
	

	/**
	* Register services.
	*
	* @return void
	*/
	public function register() {
		$this->loadViewsFrom (__DIR__ . '/../Resources/views/', 'forms');
		$this->mergeConfigFrom (__DIR__ . '/../Resources/config/forms.php', 'forms');
	}
	
	
	/**
	* Bootstrap services.
	*
	* @return void
	*/
	public function boot() {
	
		$this->publishes([
			__DIR__ . '/../Resources/config/forms.php' => config_path('forms.php'),
		], 'forms');
		
		
		//
		// Blade Components
		//
		$this->configureComponents();
		
		
		//
		// Query Builders
		//
		
		Builder::macro('search', function ($field, $search) {
						
			if (
				is_string ($field) && $field != '' &&
				is_string ($search) && $search != ''
			) {
				$this->where($field, 'like', '%' . $search . '%');
			}
			
			return $this;
			
		});
		
		
		Builder::macro('multiFieldSearch', function ($fields, $search) {
						
			if (is_string ($fields) && $fields != '') {
				$fields = explode (',', $fields);
			}
			
			if (
				is_array ($fields) && !empty ($fields) && 
				is_string ($search) && $search != ''
			) {
				
				$this->where(function ($query) use ($fields, $search) {
					foreach ($fields as $field) {	
						$query->orWhere($field, 'like', '%' . $search . '%');
					}
				});
				
			}
			
			return $this;
			
		});
		
		
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
		Builder::macro('multiFieldSort', function ($fields) {
				
				
			if (is_string ($fields) && $fields != '') {
				
				$clean = [];
				foreach (explode(',', $fields) as $field_dir) {
					$fd = explode(':', $field_dir);
					$clean[$fd[0]] = (isset ($fd[1])) ? $fd[1] : 'asc';
				}
				
				foreach ($clean as $field => $dir) {
					$this->orderBy ($field, $dir);
				}
				
			}
			else if (is_array ($fields)) {
				
				$clean = [];
				foreach ($fields as $key => $field_dir) {
					if (is_string ($key) && $key != '') {
						$clean[$key] = $field_dir;
					}
					else {
						$fd = explode(':', $field_dir);
						$clean[$fd[0]] = (isset ($fd[1])) ? $fd[1] : 'asc';
					}
				}
				
				foreach ($clean as $field => $dir) {
					$this->orderBy ($field, $dir);
				}
			}
		
			return $this;
			
		});
		
		
		//
		// @param $field - string
		// @param $ids - string or array
		//
		Builder::macro('exclude', function (string $field, $ids) {
				
			if (is_string ($ids) && $ids != '') {
				
				$clean = [];
				foreach (explode(',', $ids) as $id) {
					$clean[] = trim ($id);
				}
				
				$this->whereNotIn ($field, $ids);
				
			}
			else if (is_array ($ids)) {
				
				$clean = [];
				foreach ($ids as $id) {
					if (is_string ($id)) {
						$clean = trim ($id);
					}
				}
				
				$this->whereNotIn ($field, $ids);

			}
		
			return $this;
			
		});
		
		
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
		Blade::component ('forms::components.' . $component, 'forms-' . $component);
    }
  
}
