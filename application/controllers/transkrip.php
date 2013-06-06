<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transkrip
 *
 * @author Indra
 */
class Transkrip extends MY_Controller {

    protected $_title = 'Transkrip Mahasiswa';
    protected $_page_name = 'Detail Transkrip';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('transkrip');

        $this->load->model("mahasiswa_model");
        $this->load->model("transkrip_model");
        $this->load->helper("nilai_helper");
    }

    function index($msg = null) {
        try {
            $session_data = $this->session->userdata('logged_in');
            $level = $session_data['level'];

            $crud = new grocery_CRUD();

            $crud->set_table('transkrip');
            $crud->set_subject('Transkrip');
            $crud->required_fields('no_seri', 'mahasiswa', 'yudisium', 'reg_ijazah', 'karya_tulis', 'lambang');
            $crud->columns('no_seri', 'mahasiswa', 'yudisium', 'reg_ijazah', 'karya_tulis', 'lambang');
            $crud->display_as('no_seri', 'No. Seri');
            $crud->display_as('yudisium', 'Tgl. Yudisium');
            $crud->display_as('reg_ijazah', 'No. Reg. Ijazah');
            $crud->display_as('karya_tulis', 'Karya Tulis');
            $crud->callback_column('no_seri', array($this, 'valueToCenter'));
            $crud->callback_column('reg_ijazah', array($this, 'valueToCenter'));
            $crud->callback_column('lambang', array($this, 'valueToCenter'));
            $crud->callback_column('yudisium', array($this, 'valueDateDisplay'));
            $crud->set_relation('mahasiswa', 'mahasiswa', '{nim} - {nama}', NULL, 'mahasiswa.nama');
            $crud->add_action('Lihat Transkrip', $this->config->base_url() . 'assets/images/rincian.png', 'transkrip/view');
            if ($level === 'M') {
                $nim = $session_data['username'];
                $mahasiswa = $this->mahasiswa_model->get_by_nim($nim)->row();
                $crud->where('mahasiswa', $mahasiswa->id);
            }

            if ($level != 'A') {
                $crud->unset_operations();
            }

            $output = $crud->render();

            $output->system_messages = $msg;
            $output->view_mode = false;
            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    function view() {
        $this->set_active_view('transkrip');
        $this->set_title('Informasi Mahasiswa');
        $output = (object) $this->_blank_vars;

        $id_transkrip = 0;
        if ($this->uri->segment(2) == TRUE) {
            if ($this->uri->segment(2) == 'view') {
                if ($this->uri->segment(3) == TRUE) {
                    $id_transkrip = $this->uri->segment(3);
                }
            }
        }

        // populate data
        $transkrip = $this->transkrip_model->get_by_id($id_transkrip)->row();

        if (!$transkrip) {
            redirect('transkrip', 'refresh');
        }

        $transkrip->nilai = bobot_mutu($transkrip->lambang);
        $mahasiswa = $this->mahasiswa_model->get_by_id($transkrip->mahasiswa)->row();

        // check for unauthorize access
        $session_data = $this->session->userdata('logged_in');
        $level = $session_data['level'];
        $nim = $session_data['username'];

        if ($level === 'M' && $mahasiswa->nim != $nim) {
            redirect('transkrip', 'refresh');
        }

        $data = $this->transkrip_model->get_transkrip_by_mahasiswa($mahasiswa->id);
        $jumlah_sks = $this->transkrip_model->get_jumlah_sks_transkrip_by_mahasiswa($mahasiswa->id);
        $jumlah_mutu = $this->transkrip_model->get_jumlah_mutu_transkrip_by_mahasiswa($mahasiswa->id);

        // assign to view
        $output->mahasiswa = $mahasiswa;
        $output->transkrip = $transkrip;
        $output->data = $data;
        $output->jumlah_sks = $jumlah_sks;
        $output->jumlah_mutu = $jumlah_mutu;
        $output->ipk = number_format($jumlah_mutu / $jumlah_sks, 2);
        $output->view_mode = true;
        $this->_page_output($output);
    }

}

/* End of file transkrip.php */
/* Location: ./application/controllers/transkrip.php */