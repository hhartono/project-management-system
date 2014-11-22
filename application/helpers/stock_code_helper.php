<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('stock_code_generator')) {
    function stock_code_generator($name) {
        $name_array = explode(' ', $name);
        $first_letter = '';

        foreach($name_array as $each_word){
            $first_letter .= substr($each_word, 0, 1);
        }
        $first_letter = strtoupper($first_letter);

        // need to generate 15 characters long stock code
        $stock_code = $first_letter;

        return $name;
    }
}