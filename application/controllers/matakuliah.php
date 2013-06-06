<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of matakuliah
 *
 * @author Indra
 */
class Matakuliah extends MY_Controller {

    protected $_title = 'Manajemen Mata Kuliah';
    protected $_page_name = 'Mata Kuliah';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('matakuliah');
        
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

            // construc the table and subject
            $crud->set_table('matakuliah');
            $crud->set_subject('Mata Kuliah');
            $crud->required_fields('kode', 'jurusan', 'nama', 'semester', 'kredit');
            $crud->columns('kode', 'jurusan', 'nama', 'semester', 'kredit');
            $crud->fields('kode', 'jurusan', 'nama', 'semester', 'kredit');
            $crud->display_as('nama', 'Mata Kuliah');
            $crud->display_as('kredit', 'Kredit (SKS)');
            $crud->set_relation('jurusan', 'jurusan', 'nama');
            // assign callback & rules for kredit column
            $crud->callback_column('kredit', array($this, 'valueToSks'));
            $crud->callback_column('semester', array($this, 'valueToSemester'));
            // assign callback & rules for kode column
            $crud->callback_column('kode', array($this, 'valueToCenter'));

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
            show_error($e->getMessage() . '--- ' . $e->getTraceAsString());
        }
    }

}

/* End of file matakuliah.php */
/* Location: ./application/controllers/matakuliah.php */