<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jurusan
 *
 * @author Indra
 */
class Jurusan extends MY_Controller {

    protected $_title = 'Manajemen Jurusan';
    protected $_page_name = 'Jurusan';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
        
        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('jurusan');
        
        $this->load->model('fakultas_model');
    }

    public function index() {
        try {
            $id_fakultas = 0;
            if ($this->uri->segment(3) == TRUE) {
                if ($this->uri->segment(3) == 'add') {
                    if ($this->uri->segment(4) == TRUE) {
                        $id_fakultas = $this->uri->segment(4);
                    }
                }
            }

            $crud = new grocery_CRUD();

            $crud->set_table('jurusan');
            $crud->set_subject('Jurusan');
            $crud->required_fields('fakultas', 'nama');
            $crud->columns('fakultas', 'nama', 'keterangan');
            $crud->fields('fakultas', 'nama', 'keterangan');
            $crud->set_relation('fakultas', 'fakultas', 'nama');
            $crud->display_as('nama', 'Jurusan');
            $crud->display_as('fakultas', 'Fakultas');
            $crud->add_action('Tambah Mata Kuliah', $this->config->base_url() . 'assets/images/matakuliah.png', 'matakuliah/index/add');
            $crud->add_action('Tambah Kelas', $this->config->base_url() . 'assets/images/kelas.png', 'kelas/index/add');

            if ($id_fakultas != 0) {
                $crud->field_type('fakultas', 'hidden', $id_fakultas);
                $query = $this->fakultas_model->get_by_id($id_fakultas);
            }

            $output = $crud->render();
            if (isset($query)) {
                $output->fakultas = $query->result_array();
            }

            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }    

}

/* End of file jurusan.php */
/* Location: ./application/controllers/jurusan.php */