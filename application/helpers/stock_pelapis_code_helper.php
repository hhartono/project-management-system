<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('stock_code_generator')) {
    function stock_code_generator($category_id, $supplier_id) {
        $max_code_length = 7;
        $max_category_prefix_length = 3;

        // get category detail
        $CI = get_instance();
        $CI->load->model('category_model');
        $CI->load->model('stock_pelapis_model');
        $category_detail = $CI->category_model->get_category_by_id($category_id);

        // generate the code
        if(empty($category_detail['prefix'])){
            return false;
        }else{
            // check the length of the category prefix
            $prefix_length = strlen($category_detail['prefix']);

            if($prefix_length > $max_category_prefix_length){
                return false;
            }else{
                $stock_code = $category_detail['prefix'] . $supplier_id;
                $stock_code_length = strlen($stock_code);

                if($stock_code_length > $max_code_length){
                    return false;
                }else{
                    do{
                        // search for latest stock code in use
                        $required_length_number = $max_code_length - $stock_code_length;
                        $min_random_number = 1;
                        $max_random_number = 1;

                        for($walk = 0; $walk < ($required_length_number - 1); $walk++){
                            $min_random_number *= 10;
                            $max_random_number *= 10;
                        }
                        $max_random_number *= 10;
                        $max_random_number -= 1;

                        // generate code for stock
                        $generated_number = mt_rand($min_random_number, $max_random_number);
                        $generated_stock_code = $stock_code . $generated_number;

                        // check for duplicate
                        $duplicate_status = true;
                        $duplicate_check = $CI->stock_pelapis_model->get_stock_by_stock_code($generated_stock_code);
                        if(empty($duplicate_check)){
                            $duplicate_status = false;
                        }
                    }while($duplicate_status === true);

                    // create a 10 character long stock code
                    return $generated_stock_code;
                }
            }
        }
    }
}