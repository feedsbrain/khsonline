<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of main
 *
 * @author Indra
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
        $output->nama = $session_data['name'];
        $this->_page_output($output);
    }

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */