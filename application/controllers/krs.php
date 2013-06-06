<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Krs Controller
 * 
 * File: krs.php
 * 
 * @package application/controllers
 * @author Indra <indra@indragunawan.com>
 */
class Krs extends MY_Controller {

    protected $_title = 'Informasi Mahasiswa';
    protected $_page_name = 'Kartu Studi';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'manajemen');
        $this->set_active_view('krs');

        $this->load->model('mahasiswa_model');
        $this->load->model('kelas_model');
        $this->load->model('krs_model');
        $this->load->model('krsdetail_model');
        $this->load->model('matakuliah_model');
        $this->load->model('transkrip_model');
        $this->load->helper('form_helper');
    }

    function index($msg = null) {
        try {
            $mahasiswa_id = 0;
            $session_data = $this->session->userdata('logged_in');
            $nim = $session_data['username'];
            $level = $session_data['level'];

            $mahasiswa = $this->mahasiswa_model->get_by_nim($nim)->row();
            if ($mahasiswa) {
                $mahasiswa_id = $mahasiswa->id;
            }

            $crud = new grocery_CRUD();

            $crud->set_table('krs');
            $crud->set_subject('Kartu Studi');
            $crud->required_fields('mahasiswa', 'tahun', 'semester', 'dibuat_oleh', 'tanggal_dibuat', 'posted');
            if ($level === 'M') {
                $crud->columns('tahun', 'semester', 'dibuat_oleh', 'tanggal_dibuat', 'diubah_oleh', 'tanggal_diubah', 'posted');
                $crud->where('mahasiswa', $mahasiswa_id);
            } else {
                $crud->columns('mahasiswa', 'tahun', 'semester', 'dibuat_oleh', 'tanggal_dibuat', 'diubah_oleh', 'tanggal_diubah', 'posted');
            }
            $crud->callback_column('tahun', array($this, 'valueToTahunAjaran'));
            $crud->callback_column('semester', array($this, 'valueToSemester'));
            $crud->callback_column('posted', array($this, 'valuePostedKhs'));
            $crud->callback_column('tanggal_dibuat', array($this, 'valueDateTimeDisplay'));
            $crud->callback_column('tanggal_diubah', array($this, 'valueDateTimeDisplay'));
            $crud->field_type('posted', 'hidden');
            $crud->display_as('tahun', 'Tahun Ajaran');
            $crud->display_as('posted', 'Status');
            $crud->display_as('dibuat_oleh', 'Dibuat Oleh');
            $crud->display_as('tanggal_dibuat', 'Tgl. Dibuat');
            $crud->display_as('diubah_oleh', 'Diubah Oleh');
            $crud->display_as('tanggal_diubah', 'Tgl. Diubah');
            $crud->set_relation('mahasiswa', 'mahasiswa', 'nama');
            $crud->set_relation('dibuat_oleh', 'users', 'name');
            $crud->set_relation('diubah_oleh', 'users', 'name');
            $crud->add_action('Rincian', $this->config->base_url() . 'assets/images/rincian.png', 'krs/detail');

            $crud->unset_operations();

            $output = $crud->render();

            $output->detail_mode = false;
            $output->system_messages = $msg;
            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    function detail() {
        try {
            $id_krs = 0;
            if ($this->uri->segment(2) == TRUE) {
                if ($this->uri->segment(2) == 'detail') {
                    if ($this->uri->segment(3) == TRUE) {
                        $id_krs = $this->uri->segment(3);
                    }
                }
            }

            $session_data = $this->session->userdata('logged_in');
            $level = $session_data['level'];

            $krs = $this->krs_model->get_by_id($id_krs)->row();
            $mahasiswa = $this->mahasiswa_model->get_by_id($krs->mahasiswa)->row();
            $kelas = $this->kelas_model->get_by_id($mahasiswa->kelas)->row();

            $crud = new grocery_CRUD();

            $crud->set_table('krsdetail');
            $crud->set_subject('Mata Kuliah');
            $crud->required_fields('krs', 'matakuliah');

            if ($krs->posted) {
                $crud->columns('matakuliah', 'kode', 'sks', 'nilai', 'mutu', 'alpa', 'izin', 'sakit', 'penilai', 'tanggal_dinilai');
                $crud->set_relation('penilai', 'users', 'name');
                $crud->display_as('tanggal_dinilai', 'Tgl. Dinilai');
                $crud->callback_column('tanggal_dinilai', array($this, 'valueDateTimeDisplay'));                                
            } else {
                $crud->columns('matakuliah', 'kode', 'sks');
            }

            $crud->display_as('sks', 'SKS');
            $crud->display_as('kode', 'Kode');
            $crud->callback_column('sks', array($this, 'get_matakuliah_sks'));
            $crud->callback_column('kode', array($this, 'get_matakuliah_kode'));

            $crud->fields('krs', 'matakuliah');
            $crud->callback_column('nilai', array($this, 'valueToCenter'));
            $crud->callback_column('alpa', array($this, 'valueToCenter'));
            $crud->callback_column('izin', array($this, 'valueToCenter'));
            $crud->callback_column('sakit', array($this, 'valueToCenter'));

            if ($level === 'A' || $level === 'D') {
                if ($krs->posted) {
                    $crud->fields('krs', 'nilai', 'alpa', 'izin', 'sakit', 'penilai', 'tanggal_dinilai');
                    $crud->field_type('penilai', 'hidden');
                    $crud->field_type('tanggal_dinilai', 'hidden');
                }
                $crud->callback_before_update(array($this, 'update_penilai_info'));
            } else {
                $crud->callback_after_update(array($this, 'update_krs_edit_info'));
            }            
            
            if ($krs->posted) {
                $crud->callback_column('nilai', array($this, 'valueNilaiToBobot'));
                $crud->callback_column('mutu', array($this, 'get_mutu_calculation'));
            }

            $crud->display_as('matakuliah', 'Mata Kuliah');
            $crud->set_relation('matakuliah', 'matakuliah', '{nama} (S:{semester})', array('jurusan' => $kelas->jurusan, 'semester <=' => $krs->semester), 'nama');
            $crud->change_field_type('krs', 'hidden', $id_krs);
            $crud->where('krsdetail.krs', $id_krs);

            if ($krs->posted) {
                $crud->unset_add();
                if ($level === 'M') {
                    $crud->unset_edit();
                }
                $crud->unset_delete();
            }

            $output = $crud->render();

            $output->tahun_ajaran = $this->valueToTahunAjaranDisplay($krs->tahun);
            $output->semester = $this->valueToSemesterDisplay($krs->semester);
            $output->id_krs = $krs->id;
            $output->detail_mode = true;
            $output->nama_mahasiswa = $mahasiswa->nama;
            $output->nim = $mahasiswa->nim;
            $output->level = $level;
            $output->jumlah_sks = $this->krs_model->get_jumlah_sks_krs($krs->id);
            if ($krs->posted) {
                $output->jumlah_mutu = $this->krs_model->get_jumlah_mutu_krs($krs->id);
                $output->ips = number_format($this->krs_model->get_nilai_krs($krs->id), 2);
                $output->ipk_sementara = number_format($this->transkrip_model->get_jumlah_ipk_semester($krs->semester, $krs->mahasiswa), 2);
            }
            $output->krs_posted = $krs->posted;
            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
    
    public function get_mutu_calculation($value, $row) {
        $matakuliah = $this->matakuliah_model->get_by_id($row->matakuliah)->row();
        $krsdetail = $this->krsdetail_model->get_by_id($row->id)->row();
        return $this->valueToCenter($matakuliah->kredit * bobot_mutu(nilai_bobot($krsdetail->nilai)), $row);
    }

    public function get_matakuliah_kode($value, $row) {
        $matakuliah = $this->matakuliah_model->get_by_id($row->matakuliah)->row();
        return $this->valueToCenter($matakuliah->kode, $row);
    }

    public function get_matakuliah_sks($value, $row) {
        $matakuliah = $this->matakuliah_model->get_by_id($row->matakuliah)->row();
        return $this->valueToCenter($matakuliah->kredit, $row);
    }

    function update_krs_edit_info($post_array, $primary_key) {
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];

        $krs = $this->krs_model->get_by_id($post_array['krs'])->row();
        $this->krs_model->update($krs->id, array('diubah_oleh' => $user_id, 'tanggal_diubah' => date("Y-m-d H:i:s")));

        return true;
    }

    function update_penilai_info($post_array, $primary_key) {
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];

        $post_array['penilai'] = $user_id;
        $post_array['tanggal_dinilai'] = date("Y-m-d H:i:s");

        return $post_array;
    }

    public function posting() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $level = $session_data['level'];
            $user_id = $session_data['id'];

            $id_krs = 0;
            if ($this->uri->segment(2) == TRUE) {
                if ($this->uri->segment(2) == 'posting') {
                    if ($this->uri->segment(3) == TRUE) {
                        $id_krs = $this->uri->segment(3);
                    }
                }
            }

            if ($level === 'A' || $level === 'D') {
                $this->krs_model->update($id_krs, array('posted' => true, 'diubah_oleh' => $user_id, 'tanggal_diubah' => date("Y-m-d H:i:s")));
                $this->_messages->add('Data berhasil diposting', 'success');
            } else {
                $this->_messages->add('Data gagal diposting', 'warning');
            }
            $msg = $this->_messages->get_messages();
            $this->index($msg);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

}

/* End of file krs.php */
/* Location: ./application/controllers/krs.php */