<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Main Controller
 * 
 * File: main.php
 * 
 * @package application/controllers
 * @author Indra <indra@indragunawan.com>
 */
class Main extends MY_Controller {

    protected $_title = 'KHS Online';
    protected $_page_name = 'Menu Utama';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('main', 'main');
        $this->set_active_view('main');
    }
    
    public function index() {
        $output = (object) $this->_blank_vars;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data && $session_data['level']) {
            $level = $session_data['level'];
            if ($level === 'A' || $level === 'D') {
                redirect('backoffice', 'refresh');
            }
        }
        $output->nama = $session_data['name'];
        $this->_page_output($output);
    }

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */