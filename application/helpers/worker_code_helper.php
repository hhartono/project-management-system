<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('worker_code_generator')) {
    function worker_code_generator($division_id) {
        $max_code_length = 10;
        $max_division_code_length = 3;

        // get category detail
        $CI = get_instance();
        $CI->load->model('division_model');
        $CI->load->model('worker_model');
        $division_detail = $CI->division_model->get_division_by_id($division_id);

        // generate the code
        if(empty($division_detail['division_code'])){
            return false;
        }else{
            // check the length of the category prefix
            $division_code_length = strlen($division_detail['division_code']);

            if($division_code_length > $max_division_code_length){
                return false;
            }else{
                $worker_code = $division_detail['division_code'];
                $worker_code_length = strlen($worker_code);

                if($worker_code_length > $max_code_length){
                    return false;
                }else{
                    do{
                        // search for latest worker code in use
                        $required_length_number = $max_code_length - $worker_code_length;
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
                        $generated_worker_code = $worker_code . $generated_number;

                        // check for duplicate
                        $duplicate_status = true;
                        $duplicate_check = $CI->worker_model->get_worker_by_worker_code($generated_worker_code);
                        if(empty($duplicate_check)){
                            $duplicate_status = false;
                        }
                    }while($duplicate_status === true);

                    // create a 10 character long stock code
                    return $generated_worker_code;
                }
            }
        }
    }
}