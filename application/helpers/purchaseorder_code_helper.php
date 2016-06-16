<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('purchaseorder_code_generator')) {
    function purchaseorder_code_generator() {
        $max_code_length = 10;
        $purchaseorder_prefix = 'PO';

        // get category detail
        $CI = get_instance();
        $CI->load->model('purchaseorder_model');

        // check the length of the purchase order prefix
        $purchaseorder_code = $purchaseorder_prefix;
        $purchaseorder_code_length = strlen($purchaseorder_code);

        if($purchaseorder_code_length > $max_code_length){
            return false;
        }else{
            do{
                // search for latest worker code in use
                $required_length_number = $max_code_length - $purchaseorder_code_length;
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
                $generated_purchaseorder_code = $purchaseorder_code . $generated_number;

                // check for duplicate
                $duplicate_status = true;
                $duplicate_check = $CI->purchaseorder_model->get_purchaseorder_by_purchaseorder_code($generated_purchaseorder_code);
                if(empty($duplicate_check)){
                    $duplicate_status = false;
                }
            }while($duplicate_status === true);

            // create a 10 character long stock code
            return $generated_purchaseorder_code;
        }
    }
}