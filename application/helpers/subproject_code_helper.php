<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('subproject_code_generator')) {
    function subproject_code_generator($project_id) {
        $max_code_length = 10;

        // get category detail
        $CI = get_instance();
        $CI->load->model('project_model');
        $project_detail = $CI->project_model->get_project_by_id($project_id);

        // generate the code
        if(empty($project_detail['project_initial'])){
            return false;
        }else{
            // check the length of the category prefix
            $project_initial_length = strlen($project_detail['project_initial']);

            if($project_initial_length > 5){
                return false;
            }else{
                $subproject_code = $project_detail['project_initial'];
                $subproject_code_length = strlen($subproject_code);

                if($subproject_code_length > $max_code_length){
                    return false;
                }else{
                    do{
                        // search for latest subproject code in use
                        $required_length_number = $max_code_length - $subproject_code_length;
                        $min_random_number = 1;
                        $max_random_number = 1;

                        for($walk = 0; $walk < ($required_length_number - 1); $walk++){
                            $min_random_number *= 10;
                            $max_random_number *= 10;
                        }
                        $max_random_number *= 10;
                        $max_random_number -= 1;

                        // generate code for subproject
                        $generated_number = mt_rand($min_random_number, $max_random_number);
                        $generated_subproject_code = $subproject_code . $generated_number;

                        // check for duplicate
                        $duplicate_status = true;
                        $duplicate_check = $CI->subproject_model->get_subproject_by_subproject_code($generated_subproject_code);
                        if(empty($duplicate_check)){
                            $duplicate_status = false;
                        }
                    }while($duplicate_status === true);

                    // create a 10 character long stock code
                    return $generated_subproject_code;
                }
            }
        }
    }
}