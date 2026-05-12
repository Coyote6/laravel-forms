<?php

namespace Coyote6\LaravelForms\Facades;

use Illuminate\Support\Facades\Facade;

class Form extends Facade
{
    /**
     * Get the registered name of the component in the IoC container.
     * This must match the binding key used in the ServiceProvider.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'coyote6.form';
    }
}