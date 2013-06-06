<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Spp Controller
 * 
 * File: spp.php
 * 
 * @package application/controllers
 * @author Indra <indra@indragunawan.com>
 */
class Spp extends MY_Controller {

    protected $_title = 'Manajemen SPP';
    protected $_page_name = 'SPP';
    protected $_valid_access = array('A');

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('spp');

        $this->load->model('spp_model');
    }

    function index($msg = null) {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('spp');
            $crud->set_subject('SPP');
            $crud->required_fields('nama', 'tahun', 'semester');
            $crud->columns('nama', 'tahun', 'semester', 'jumlah', 'posted');
            $crud->callback_column('tahun', array($this, 'valueToTahunAjaran'));
            $crud->callback_column('semester', array($this, 'valueToSemester'));
            $crud->callback_column('jumlah', array($this, 'get_sum_detail'));
            $crud->callback_column('posted', array($this, 'valuePostedStatus'));
            $crud->field_type('posted', 'hidden');
            $crud->display_as('tahun', 'Tahun Ajaran');
            $crud->display_as('posted', 'Penetapan');
            $crud->order_by('tahun', 'desc');
            $crud->order_by('semester', 'desc');
            $crud->order_by('nama', 'asc');
            $crud->add_action('Rincian', $this->config->base_url() . 'assets/images/rincian.png', 'spp/detail');
            $crud->add_action('Pembayaran', $this->config->base_url() . 'assets/images/pembayaran.png', 'pembayaran/index/spp');

            $output = $crud->render();

            $output->detail_mode = false;
            $output->system_messages = $msg;
            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function get_sum_detail($value, $row) {
        return $this->valueToNumber($this->spp_model->get_detail_sum($row->id), $row);
    }

    function detail() {
        try {
            $id_spp = 0;
            if ($this->uri->segment(2) == TRUE) {
                if ($this->uri->segment(2) == 'detail') {
                    if ($this->uri->segment(3) == TRUE) {
                        $id_spp = $this->uri->segment(3);
                    }
                }
            }

            $spp = $this->spp_model->get_by_id($id_spp)->row();

            $crud = new grocery_CRUD();

            $crud->set_table('sppdetail');
            $crud->set_subject('Rincian SPP');
            $crud->required_fields('spp', 'keterangan', 'jumlah');
            $crud->columns('keterangan', 'jumlah');
            $crud->set_relation('spp', 'spp', 'tahun');
            $crud->change_field_type('spp', 'hidden', $id_spp);
            $crud->callback_column('jumlah', array($this, 'valueToNumber'));
            $crud->where('spp', $id_spp);

            if ($spp->posted) {
                $crud->unset_operations();
            }

            $output = $crud->render();

            $output->nama_spp = $spp->nama;
            $output->tahun_ajaran = $this->valueToTahunAjaranDisplay($spp->tahun);
            $output->semester = $this->valueToSemesterDisplay($spp->semester);
            $output->id_spp = $spp->id;
            $output->detail_mode = true;
            $output->spp_posted = $spp->posted;
            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function posting() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $level = $session_data['level'];

            $id_spp = 0;
            if ($this->uri->segment(2) == TRUE) {
                if ($this->uri->segment(2) == 'posting') {
                    if ($this->uri->segment(3) == TRUE) {
                        $id_spp = $this->uri->segment(3);
                    }
                }
            }

            if ($level == 'A' || $level == 'D') {
                $this->spp_model->update($id_spp, array('posted' => true));
            }
            $this->_messages->add('Data berhasil diposting', 'success');
            $msg = $this->_messages->get_messages();
            $this->index($msg);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

}

/* End of file spp.php */
/* Location: ./application/controllers/spp.php */