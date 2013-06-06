<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fakultas
 *
 * @author Indra
 */
class Fakultas extends MY_Controller {

    protected $_title = 'Manajemen Fakultas';
    protected $_page_name = 'Fakultas';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('index');
    }

    function index() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('fakultas');
            $crud->set_subject('Fakultas');
            $crud->required_fields('nama');
            $crud->columns('nama', 'keterangan');
            $crud->display_as('nama', 'Fakultas');
            $crud->add_action('Tambah Jurusan', $this->config->base_url() . 'assets/images/jurusan.png', 'jurusan/index/add');

            $output = $crud->render();

            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

}

/* End of file fakultas.php */
/* Location: ./application/controllers/fakultas.php */