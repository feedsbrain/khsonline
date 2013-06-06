<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pengaturan
 *
 * @author Indra
 */
class Pengaturan extends MY_Controller {

    protected $_title = 'Pengaturan Aplikasi';
    protected $_page_name = 'Pengaturan';

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