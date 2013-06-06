<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Pengaturan Controller
 * 
 * File: pengaturan.php
 * 
 * @package application/controllers
 * @author Indra <indra@indragunawan.com>
 */
class Pengaturan extends MY_Controller {

    protected $_title = 'Pengaturan Aplikasi';
    protected $_page_name = 'Pengaturan';
    protected $_valid_access = array('A');

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'konfigurasi');
        $this->set_active_view('index');
    }

    function index() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('config');
            $crud->set_subject('Pengaturan');
            $crud->required_fields('key', 'value');
            $crud->columns('key', 'value');
            $crud->change_field_type('password', 'password');

            $output = $crud->render();

            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

}

/* End of file pengaturan.php */
/* Location: ./application/controllers/pengaturan.php */