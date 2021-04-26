<?php
	
	
namespace Coyote6\LaravelForms\Form;


use \Illuminate\View\ComponentAttributeBag;


class AttributeBag extends ComponentAttributeBag {
	
	/**
     * Implode the attributes into a single HTML ready string.
     *
     * @return string
     */
    public function __toString() {
        $string = '';

        foreach ($this->attributes as $key => $value) {
            if ($value === false || is_null($value)) {
                continue;
            }

            if ($value === true) {
            	$string .= ' '.$key;
            }
			else {
	            $string .= ' '.$key.'="'.str_replace('"', '\\"', trim($value)).'"';
			}
        }

        return trim($string);
    }
    
}
