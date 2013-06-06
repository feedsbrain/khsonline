<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This is default controller class for KHS Application
 *
 * @author Indra
 */
class MY_Controller extends CI_Controller {

    protected $_title = 'KHS Online (Backoffice)';
    protected $_page_name = 'Main Page';
    protected $_blank_vars = array('output' => '', 'js_files' => array(), 'css_files' => array());
    protected $_main_module = 'backoffice';
    protected $_side_module = 'backoffice';
    protected $_user_level = 'A';
    protected $_active_view = 'index';
    protected $_messages;

    public function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->load->library('grocery_CRUD');
        $this->load->library('System_message');
        $this->load->model('menu_model');
        $this->load->helper('theme_helper');
        $this->load->helper('nilai_helper');

        $this->_messages = new System_message();
    }

    public function index() {
        $this->_page_output((object) $this->_blank_vars);
    }

    protected function _page_output($output = null) {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $output->username = $session_data['name'];
            $this->_user_level = $session_data['level'];
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
        $output->title = $this->_title;
        $output->page_name = $this->_page_name;
        $output->main_menu = $this->_populate_main_menu($this->_main_module);
        $output->side_menu = $this->_populate_side_menu($this->_side_module);
        $output->system_messages = $this->_messages->get_messages();
        $this->_load_theme_and_view($output);
    }

    protected function _load_theme_and_view($output = null) {
        $this->load->theme(theme_name());
        $this->load->view($this->_active_view, $output);
    }

    // Must overrided on children
    protected function _populate_main_menu_with_level($user_level = null, $module = null) {
        return $this->menu_model->populate_main_menu($user_level, $module);
    }

    // Must overrided on children
    protected function _populate_side_menu_with_level($user_level = null, $module = null) {
        return $this->menu_model->populate_side_menu($user_level, $module);
    }

    // Must overrided on children
    protected function _populate_main_menu($module = null) {
        return $this->menu_model->populate_main_menu($this->_user_level, $module);
    }

    // Must overrided on children
    protected function _populate_side_menu($module = null) {
        return $this->menu_model->populate_side_menu($this->_user_level, $module);
    }

    public function valueNilaiToBobot($value, $row) {
        $bobot = nilai_bobot($value);
        return $this->valueToCenter($bobot, $row);
    }
    
    public function valueBobotToMutu($value, $row) {
        $mutu = bobot_mutu($value);
        return $this->valueToCenter($mutu, $row);
    }

    public function valueToCenter($value, $row) {
        return '<center>' . $value . '</center>';
    }

    public function valueToSks($value, $row) {
        return $this->valueToCenter($value . ' SKS', $row);
    }

    public function valueToSemester($value, $row) {
        return $this->valueToCenter($this->valueToSemesterDisplay($value), $row);
    }

    public function valueToSemesterDisplay($value) {
        if ($value % 2 != 0) {
            return $value . ' (Ganjil)';
        } else {
            return $value . ' (Genap)';
        }
    }

    public function valueActiveStatus($value, $row) {
        return $this->valueToCenter($this->activeStatus($value), $row);
    }

    public function valuePostedStatus($value, $row) {
        return $this->valueToCenter($this->booleanDisplay($value), $row);
    }

    public function valuePostedKhs($value, $row) {
        return $this->valueToCenter($this->khsOrKrsStatus($value), $row);
    }

    public function valueDateDisplay($value, $row) {
        if ($value) {
            return $this->valueToCenter(date("d/m/Y", strtotime($value)), $row);
        } else {
            return '';
        }
    }
    
    public function valueDateTimeDisplay($value, $row) {
        if ($value) {
            return $this->valueToCenter(date("d/m/Y H:i", strtotime($value)), $row);
        } else {
            return '';
        }
    }

    public function activeStatus($value) {
        switch ($value) {
            case 1:
                return 'Active';
                break;
            default:
                return 'Inactive';
                break;
        }
    }

    public function khsOrKrsStatus($value) {
        switch ($value) {
            case 1:
                return 'KHS';
                break;
            default:
                return 'KRS';
                break;
        }
    }

    public function booleanDisplay($value) {
        switch ($value) {
            case 1:
                return 'Ya';
                break;
            default:
                return 'Tidak';
                break;
        }
    }

    public function valueToNumber($value, $row) {
        return '<p class="number-display">' . $this->valueToNumberDisplay($value) . '</p>';
    }

    public function valueToNumberDisplay($value) {
        return number_format($value, 0, ',', '.');
    }

    public function valueToTahunAjaran($value, $row) {
        return $this->valueToCenter($this->valueToTahunAjaranDisplay($value), $row);
    }

    public function valueToTahunAjaranDisplay($value) {
        $tahun_ajaran = $value . ' - ' . ($value + 1);
        return $tahun_ajaran;
    }

    public function set_active_module($main_module, $side_module) {
        $this->_main_module = $main_module;
        $this->_side_module = $side_module;
    }

    public function set_active_view($view) {
        $this->_active_view = $view;
    }

    public function set_title($title) {
        $this->_title = $title;
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */