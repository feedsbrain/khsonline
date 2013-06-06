<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Mahasiswa Controller
 * 
 * File: mahasiswa.php
 * 
 * @package application/controllers
 * @author Indra <indra@indragunawan.com>
 */
class Mahasiswa extends MY_Controller {

    protected $_title = 'Manajemen Mahasiswa';
    protected $_page_name = 'Mahasiswa';
    protected $_default_status = 'AKTIF';
    protected $_valid_access = array('A', 'D');

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('index');

        $this->load->model('mahasiswa_model');
    }

    function index() {
        try {
            $id_kelas = 0;
            $tahun_angkatan = 0;
            if ($this->uri->segment(3) == TRUE) {
                if ($this->uri->segment(3) == 'add') {
                    if ($this->uri->segment(4) == TRUE) {
                        $id_kelas = $this->uri->segment(4);
                    }
                    if ($this->uri->segment(5) == TRUE) {
                        $tahun_angkatan = $this->uri->segment(5);
                    }
                }
            }

            $session_data = $this->session->userdata('logged_in');
            $level = $session_data['level'];

            $crud = new grocery_CRUD();

            $crud->set_table('mahasiswa');
            $crud->set_subject('Mahasiswa');
            $crud->required_fields('nim', 'nama', 'tahun', 'kelas', 'status');
            $crud->columns('nim', 'nama', 'tahun', 'kelas', 'tempat_lahir', 'tanggal_lahir', 'status');
            $crud->fields('nim', 'nama', 'tahun', 'kelas', 'tempat_lahir', 'tanggal_lahir', 'status');
            $crud->set_relation('kelas', 'kelas', '{nama} - {keterangan}');
            $crud->display_as('tahun', 'Angkatan');
            $crud->display_as('kelas', 'Kelas');
            $crud->display_as('nim', 'NIM');
            $crud->display_as('tempat_lahir', 'Tempat Lahir');
            $crud->display_as('tanggal_lahir', 'Tgl. Lahir');
            if ($level === 'A') {
                $crud->add_action('Tambah Teman', $this->config->base_url() . 'assets/images/mahasiswa.png', '', '', array($this, 'tambah_teman_url_callback'));
            }
            $crud->callback_column('nim', array($this, 'valueToCenter'));
            $crud->callback_column('tahun', array($this, 'valueToCenter'));
            $crud->callback_column('kelas', array($this, 'valueToCenter'));
            $crud->callback_column('tempat_lahir', array($this, 'valueToCenter'));
            $crud->callback_column('tanggal_lahir', array($this, 'valueDateDisplay'));
            $crud->callback_column('status', array($this, 'valueToCenter'));

            $crud->callback_before_insert(array($this, 'trim_mahasiswa_input'));
            $crud->callback_before_update(array($this, 'trim_mahasiswa_input'));

            if ($level === 'D' || $level === 'M') {
                $crud->unset_operations();
            }

            if ($this->uri->segment(3) == TRUE) {
                if ($this->uri->segment(3) == 'add') {
                    $crud->field_type('status', 'hidden', $this->_default_status);
                }
            }

            if ($id_kelas != 0) {
                $crud->field_type('kelas', 'hidden', $id_kelas);
            }
            if ($tahun_angkatan != 0) {
                $crud->field_type('tahun', 'hidden', $tahun_angkatan);
            }

            $output = $crud->render();

            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    function tambah_teman_url_callback($primary_key, $row) {
        $mahasiswa = $this->mahasiswa_model->get_by_id($primary_key)->row();
        return site_url('mahasiswa/index/add/') . '/' . $mahasiswa->kelas . '/' . $mahasiswa->tahun;
    }

    function trim_mahasiswa_input($post_array) {
        $post_array['nim'] = trim($post_array['nim']);
        $post_array['nama'] = trim($post_array['nama']);

        return $post_array;
    }

}

/* End of file mahasiswa.php */
/* Location: ./application/controllers/mahasiswa.php */