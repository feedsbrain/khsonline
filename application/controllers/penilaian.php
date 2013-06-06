<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Penilaian Controller
 * 
 * File: penilaian.php
 * 
 * @package application/controllers
 * @author Indra <indra@indragunawan.com>
 */
class Penilaian extends MY_Controller {

    protected $_title = 'Penilaian Mahasiswa';
    protected $_page_name = 'Penilaian';
    protected $_valid_access = array('A', 'D');
    protected $_available_action = array('nilai', 'alpa', 'izin', 'sakit');

    public function __construct() {
        parent::__construct();

        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('penilaian');

        $this->load->model('krsdetail_model');
        $this->load->model('matakuliah_model');
        $this->load->helper('form_helper');
    }

    function index() {
        $tahun = 0;
        if ($this->input->post('tahun')) {
            $tahun = (int) $this->input->post('tahun');
        }
        $semester = 0;
        if ($this->input->post('semester')) {
            $semester = $this->input->post('semester');
        }
        $matakuliah = 0;
        if ($this->input->post('matakuliah')) {
            $matakuliah = $this->input->post('matakuliah');
        }

        $penilaian = $this->krsdetail_model->get_detail_for_penilaian($tahun, $semester, $matakuliah);

        $output = (object) $this->_blank_vars;
        $output->penilaian = $penilaian;
        $output->mk_list = $this->matakuliah_model->populate_for_dropdown();
        $output->mk_selected = $matakuliah;
        $output->tahun = $tahun;
        $output->semester = $semester;
        $output->matakuliah = $matakuliah;
        $this->_page_output($output);
    }

    function set() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $user_id = $session_data['id'];
            $level = $session_data['level'];
            if ($level === 'A' || $level === 'D') {
                //This method will have the credentials validation
                $this->load->library('form_validation');
                // validate post input
                $this->form_validation->set_rules('data', 'Data', 'required|numeric|xss_clean');

                $data = (int) $this->input->post('data');

                $krsdetail = 0;
                $action = '';
                if ($this->uri->segment(3) == TRUE) {
                    $action = $this->uri->segment(3);
                    if ($this->uri->segment(4) == TRUE) {
                        $krsdetail = $this->uri->segment(4);
                    }
                }

                // if validation was successful with no errors
                if ($this->form_validation->run() === true) {
                    if (in_array($action, $this->_available_action)) {
                        $instance = array(
                            $action => $data,
                            'penilai' => $user_id,
                            'tanggal_dinilai' => date("Y-m-d H:i:s")
                        );
                        $this->krsdetail_model->update($krsdetail, $instance);
                        echo true;
                    } else {
                        echo false;
                    }
                } else {
                    $this->output->set_status_header('400');
                }
            } else {
                //If user privilage is violated, redirect to login page
                redirect('main', 'refresh');
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

}

/* End of file penilaian.php */
/* Location: ./application/controllers/penilaian.php */