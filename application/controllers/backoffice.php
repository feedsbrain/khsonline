<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of backoffice
 *
 * @author Indra
 */
class Backoffice extends MY_Controller {

    protected $_title = 'KHS Online';
    protected $_page_name = 'Back Office';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
    }

    public function index() {
        $this->set_active_module('backoffice', 'backoffice');
        $this->set_active_view('backoffice');
        $this->set_title('KHS Online');
        $output = (object) $this->_blank_vars;
        $session_data = $this->session->userdata('logged_in');
        $output->nama = $session_data['name'];
        $this->_page_output($output);
    }

    public function konfigurasi() {
        $this->set_active_module('backoffice', 'konfigurasi');
        $this->set_active_view('konfigurasi');
        $this->set_title('Konfigurasi');
        $output = (object) $this->_blank_vars;
        $session_data = $this->session->userdata('logged_in');
        $output->level = $session_data['level'];
        $this->_page_output($output);
    }

    public function manajemen() {
        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('manajemen');
        $this->set_title('Manajemen');
        $output = (object) $this->_blank_vars;
        $session_data = $this->session->userdata('logged_in');
        $output->level = $session_data['level'];
        $this->_page_output($output);
    }

}

/* End of file backoffice.php */
/* Location: ./application/controllers/backoffice.php */