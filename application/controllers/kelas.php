<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Kelas Controller
 * 
 * File: kelas.php
 * 
 * @package application/controllers
 * @author Indra <indra@indragunawan.com>
 */
class Kelas extends MY_Controller {

    protected $_title = 'Manajemen Kelas';
    protected $_page_name = 'Kelas';
    protected $_valid_access = array('A');

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('kelas');
        
        $this->load->model('jurusan_model');
    }

    public function index() {
        try {
            $id_jurusan = 0;
            if ($this->uri->segment(3) == TRUE) {
                if ($this->uri->segment(3) == 'add') {
                    if ($this->uri->segment(4) == TRUE) {
                        $id_jurusan = $this->uri->segment(4);
                    }
                }
            }

            $crud = new grocery_CRUD();

            $crud->set_table('kelas');
            $crud->set_subject('Kelas');
            $crud->required_fields('nama', 'jurusan');
            $crud->columns('jurusan', 'nama', 'keterangan');
            $crud->fields('jurusan', 'nama', 'keterangan');
            $crud->set_relation('jurusan', 'jurusan', 'nama');
            $crud->display_as('nama', 'Kelas');
            $crud->display_as('jurusan', 'Jurusan');
            $crud->callback_column('nama', array($this, 'valueToCenter'));
            $crud->callback_column('jurusan', array($this, 'valueToCenter'));
            $crud->add_action('Tambah Mahasiswa', $this->config->base_url() . 'assets/images/mahasiswa.png', 'mahasiswa/index/add');

            if ($id_jurusan != 0) {
                $crud->field_type('jurusan', 'hidden', $id_jurusan);
                $query = $this->jurusan_model->get_by_id($id_jurusan);
            }

            $output = $crud->render();
            if (isset($query)) {
                $output->jurusan = $query->result_array();
            }

            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

}

/* End of file kelas.php */
/* Location: ./application/controllers/kelas.php */