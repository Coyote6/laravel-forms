<?php


namespace Coyote6\LaravelForms\Providers;


use Illuminate\Support\ServiceProvider;


class FormServiceProvider extends ServiceProvider {
	

  /**
   * Register services.
   *
   * @return void
   */
  public function register() {
    $this->loadViewsFrom (__DIR__ . '/../Resources/views/', 'laravel-forms');
  }


  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot() {
    //
  }
  
}
