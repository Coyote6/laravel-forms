<?php


namespace Coyote6\LaravelForms\Support;

use Coyote6\LaravelForms\Form;

class FormHelper
{


    // New
    //
    // Generates a new Laravel Form.
    //
    // @param $attrs - All parameters given to the method.
    // @return Form
    //
    public function new (... $params) {
        return new Form ($params);
    }


    // Lw Version
    //
    // Gets the Livewire version from the config.
    //
    // @return int
    //
    public function lwVersion () {
        return (int) config ('forms.livewire--version', 4);
    }

    
}