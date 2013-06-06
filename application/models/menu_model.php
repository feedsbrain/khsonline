<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Menu Model
 * 
 * File: menu_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
 */
class Menu_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();

        $this->load->config('menu');
    }

    function populate_main_menu($user_level, $module) {
        $populated_menu = array();
        $config_menu = (array) $this->config->item('main_menu_' . $module);
        foreach ($config_menu as $key => $value) {
            if (!empty($key)) {
                $menu_value = (array) $value;
                $route = $menu_value[0];
                $level = (array) $menu_value[1];
                if (in_array($user_level, $level)) {
                    $new_key = str_replace("_", " ", $key);
                    $menu_item = '<a href="' . base_url() . $route . '"><span>' . ucwords($new_key) . '</span></a>';
                    array_push($populated_menu, $menu_item);
                }
            }
        }
        return $populated_menu;
    }

    function populate_side_menu($user_level, $module) {
        $populated_menu = array();
        $config_menu = (array) $this->config->item('side_menu_' . $module);
        foreach ($config_menu as $key => $value) {
            if (!empty($key)) {
                $menu_value = (array) $value;
                $route = $menu_value[0];
                $level = (array) $menu_value[1];
                if (in_array($user_level, $level)) {
                    $new_key = str_replace("_", " ", $key);
                    $menu_item = '<a href="' . base_url() . $route . '"><span>' . ucwords($new_key) . '</span></a>';
                    array_push($populated_menu, $menu_item);
                }
            }
        }
        return $populated_menu;
    }

}

/* End of file menu_model.php */
/* Location: ./application/controllers/menu_model.php */