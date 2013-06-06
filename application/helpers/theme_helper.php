<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Base Theme URL
 * 
 * Create a local URL based on your basepath.
 * Segments can be passed in as a string or an array, same as site_url
 * or a URL to a file can be passed in, e.g. to an image file.
 *
 * @access	public
 * @param       string
 * @return	string
 */
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