<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('press_code_generator')) {
    function press_code_generator() {
        $max_code_length = 10;
        $kirimpress_prefix = 'KP';

        // get category detail
        $CI = get_instance();
        $CI->load->model('kirimpress_model');

        // check the length of the purchase order prefix
        $kirimpress_code = $kirimpress_prefix;
        $kirimpress_code_length = strlen($kirimpress_code);

        if($kirimpress_code_length > $max_code_length){
            return false;
        }else{
            do{
                // search for latest worker code in use
                $required_length_number = $max_code_length - $kirimpress_code_length;
                $min_random_number = 1;
                $max_random_number = 1;

                for($walk = 0; $walk < ($required_length_number - 1); $walk++){
                    $min_random_number *= 10;
                    $max_random_number *= 10;
                }
                $max_random_number *= 10;
                $max_random_number -= 1;

                // generate code for worker
                $generated_number = mt_rand($min_random_number, $max_random_number);
                $generated_kirimpress_code = $kirimpress_code . $generated_number;

                // check for duplicate
                $duplicate_status = true;
                $duplicate_check = $CI->kirimpress_model->get_kirimpress_by_kirimpress_code($generated_kirimpress_code);
                if(empty($duplicate_check)){
                    $duplicate_status = false;
                }
            }while($duplicate_status === true);

            // create a 10 character long stock code
            return $generated_kirimpress_code;
        }
    }
}