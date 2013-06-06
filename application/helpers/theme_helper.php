<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('theme_url')) {

    function theme_url($uri = '') {
        $CI = & get_instance();
        return $CI->config->base_url($uri) . 'assets/themes/' . $CI->config->slash_item('themes');
    }

}

if (!function_exists('theme_name')) {

    function theme_name() {
        $CI = & get_instance();
        return $CI->config->item('themes');
    }

}

/* End of file theme_helper.php */
/* Location: ./application/helpers/theme_helper.php */