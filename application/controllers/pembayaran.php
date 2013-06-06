<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pembayaran
 *
 * @author Indra
 */
class Pembayaran extends MY_Controller {

    protected $_title = 'Pembayaran SPP';
    protected $_page_name = 'Pembayaran';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('pembayaran');
        
        $this->load->model('pembayaran_model');
        $this->load->model('spp_model');
    }

    public function index() {
        try {
            $id_spp = 0;
            if ($this->uri->segment(3) == TRUE) {
                if ($this->uri->segment(3) == 'spp') {
                    if ($this->uri->segment(4) == TRUE) {
                        $id_spp = $this->uri->segment(4);
                    }
                } else {
                    redirect('spp', 'refresh');
                }
            } else {
                redirect('spp', 'refresh');
            }

            $spp = $this->spp_model->get_by_id($id_spp)->row();

            $crud = new grocery_CRUD();

            $crud->set_table('pembayaran');
            $crud->set_subject('Pembayaran');
            $crud->required_fields('mahasiswa', 'spp', 'tanggal', 'jumlah');
            $crud->columns('mahasiswa', 'tanggal', 'jumlah', 'dibuat_oleh', 'tanggal_dibuat', 'diubah_oleh', 'tanggal_diubah');
            $crud->callback_column('tanggal', array($this, 'valueDateTimeDisplay'));
            $crud->callback_column('tanggal_dibuat', array($this, 'valueDateTimeDisplay'));
            $crud->callback_column('tanggal_diubah', array($this, 'valueDateTimeDisplay'));
            $crud->field_type('dibuat_oleh', 'hidden');
            $crud->field_type('tanggal_dibuat', 'hidden');
            $crud->field_type('diubah_oleh', 'hidden');
            $crud->field_type('tanggal_diubah', 'hidden');
            $crud->set_rules('jumlah', 'Jumlah', 'numeric');
            $crud->set_relation('mahasiswa', 'mahasiswa', 'nama');
            $crud->set_relation('spp', 'spp', 'nama');
            $crud->set_relation('dibuat_oleh', 'users', 'name');
            $crud->set_relation('diubah_oleh', 'users', 'name');
            $crud->display_as('spp', 'SPP');
            $crud->display_as('dibuat_oleh', 'Dibuat Oleh');
            $crud->display_as('tanggal_dibuat', 'Tgl. Dibuat');
            $crud->display_as('diubah_oleh', 'Diubah Oleh');
            $crud->display_as('tanggal_diubah', 'Tgl. Diubah');

            if ($id_spp != 0) {
                $crud->change_field_type('spp', 'hidden', $id_spp);
                $crud->change_field_type('jumlah', 'hidden', $this->spp_model->get_detail_sum($id_spp));
                $crud->where('spp', $id_spp);
            }
            
            if (!$spp->posted) {
                $crud->unset_operations();
            }

            $crud->callback_column('jumlah', array($this, 'valueToNumber'));
            $crud->callback_before_insert(array($this, 'spp_mantatory_field_callback'));
            $crud->callback_before_update(array($this, 'spp_mantatory_edit_field_callback'));
            $crud->callback_after_insert(array($this, 'spp_after_insert_callback'));
            $crud->callback_before_delete(array($this, 'spp_before_delete_callback'));

            $output = $crud->render();

            $output->nama_spp = $this->valueToTahunAjaranDisplay($spp->nama);
            $output->tahun_ajaran = $this->valueToTahunAjaranDisplay($spp->tahun);
            $output->semester = $this->valueToSemesterDisplay($spp->semester);
            $output->jumlah_spp = $this->valueToNumberDisplay($this->spp_model->get_detail_sum($id_spp));
            $output->id_spp = $spp->id;

            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    function spp_after_insert_callback($post_array, $primary_key) {
        $this->pembayaran_model->generate_krs_from_pembayaran($primary_key);

        return true;
    }

    function spp_before_delete_callback($primary_key) {
        $this->pembayaran_model->remove_krs_by_pembayaran($primary_key);

        return true;
    }

    function spp_mantatory_field_callback($post_array) {
        $session_data = $this->session->userdata('logged_in');
        $post_array['dibuat_oleh'] = $session_data['id'];
        $post_array['tanggal_dibuat'] = date("Y-m-d H:i:s");

        return $post_array;
    }

    function spp_mantatory_edit_field_callback($post_array) {
        $session_data = $this->session->userdata('logged_in');
        $post_array['diubah_oleh'] = $session_data['id'];
        $post_array['tanggal_diubah'] = date("Y-m-d H:i:s");

        return $post_array;
    }

}

/* End of file pembayaran.php */
/* Location: ./application/controllers/pembayaran.php */