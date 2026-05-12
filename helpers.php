<?php

use Coyote6\LaravelForms\Facades\Form;

if (!function_exists ('form')) {
    function form () {
        return Form::new ();
    }
}

if (!function_exists ('lw_version')) {
    function lw_version () {
        return Form::lwVersion ();
    }
}

