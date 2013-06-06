<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Doc Controller
 * 
 * File: doc.php
 * 
 * @package application/controllers
 * @author Indra <indra@indragunawan.com>
 */
class Doc extends MY_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->load->library('pdf'); // Load library
        $this->pdf->fontpath = 'assets/font/'; // Specify font folder

        $this->load->model('krs_model');
        $this->load->model('transkrip_model');
        $this->load->model('config_model');
        $this->config->load('report');
    }

    private function check_doc_valid_access($nim) {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $level = $session_data['level'];
            $username = $session_data['username'];
            if ($level === 'M' && ($username != $nim)) {
                redirect('main', 'refresh');
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
        return true;
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $level = $session_data['level'];
            if ($level === 'A' || $level === 'D') {
                redirect('backoffice', 'refresh');
            } else {
                redirect('main', 'refresh');
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function transkrip() {
        $transkrip_id = 0;
        $download_mode = false;
        if ($this->uri->segment(3) == TRUE) {
            $transkrip_id = $this->uri->segment(3);
        }
        if ($this->uri->segment(4) == TRUE) {
            if ($this->uri->segment(4) == 'download') {
                $download_mode = true;
            }
        }

        $data = $this->transkrip_model->get_transkrip_for_reporting($transkrip_id);

        $this->check_doc_valid_access($data->mahasiswa->nim);

        $this->pdf->SetMargins(10, 50, 10);
        $this->pdf->AddPage();
        // title
        $this->pdf->SetFont('Arial', 'BU', '12');
        $this->pdf->Cell(0, 8, 'TRANSKRIP NILAI', 0, 1, 'C');
        // space
        $this->pdf->Cell(0, 2, '', 0, 1, 'C');
        // document info
        $this->pdf->SetFont('Arial', 'B', '9');
        $this->pdf->Cell(30, 5, 'NIM', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(50, 5, $data->mahasiswa->nim, 0, 0, 'L');
        // space
        $this->pdf->Cell(30, 5, '', 0, 0, 'C');
        $this->pdf->Cell(30, 7, 'Tgl. Yudisium', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, date("d/m/Y", strtotime($data->transkrip->yudisium)), 0, 1, 'L');
        // end line
        $this->pdf->Cell(30, 5, 'Nama', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(50, 5, $data->mahasiswa->nama, 0, 0, 'L');
        // space
        $this->pdf->Cell(30, 5, '', 0, 0, 'C');
        $this->pdf->Cell(30, 5, 'No. Reg. Ijazah', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, $data->transkrip->reg_ijazah, 0, 1, 'L');
        // end line
        $this->pdf->Cell(30, 5, 'Tempat/Tgl. Lahir', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        if (!empty($data->mahasiswa->tempat_lahir) && !empty($data->mahasiswa->tanggal_lahir)) {
            $this->pdf->Cell(50, 5, $data->mahasiswa->tempat_lahir . ', ' . date("d/m/Y", strtotime($data->mahasiswa->tanggal_lahir)), 0, 0, 'L');
        } else {
            $this->pdf->Cell(50, 5, $data->mahasiswa->tempat_lahir, 0, 0, 'L');
        }
        // space
        $this->pdf->Cell(30, 5, '', 0, 0, 'C');
        $this->pdf->Cell(30, 5, 'No. Seri Transkrip', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, $data->transkrip->no_seri, 0, 1, 'L');
        // end line
        // space
        $this->pdf->Cell(0, 5, '', 0, 1, 'C');
        // table
        $this->pdf->SetFont('Arial', 'B', 8);
        // header
        $this->pdf->Cell(10, 5, 'No', 1, 0, 'C');
        $this->pdf->Cell(130, 5, 'NAMA MATA KULIAH', 1, 0, 'C');
        $this->pdf->Cell(20, 5, 'KODE MK', 1, 0, 'C');
        $this->pdf->Cell(12, 5, 'SKS', 1, 0, 'C');
        $this->pdf->Cell(12, 5, 'NILAI', 1, 0, 'C');
        $this->pdf->Cell(12, 5, 'MUTU', 1, 1, 'C');
        // data font
        $this->pdf->SetFont('Arial', '', 8);
        // data row
        foreach ($data->row_data as $row) {
            $this->pdf->Cell(10, 5, $row->no, 1, 0, 'C');
            $this->pdf->Cell(130, 5, $row->matakuliah, 1, 0, 'L');
            $this->pdf->Cell(20, 5, $row->kodemk, 1, 0, 'C');
            $this->pdf->Cell(12, 5, $row->sks, 1, 0, 'C');
            $this->pdf->Cell(12, 5, $row->nilai, 1, 0, 'C');
            $this->pdf->Cell(12, 5, $row->mutu, 1, 1, 'C');
        }
        $this->pdf->SetFont('Arial', 'B', '9');
        // document footer
        $this->pdf->Cell(160, 5, 'Jumlah SKS : ' . number_format($data->jumlah_sks, 0), 1, 0, 'R');
        $this->pdf->Cell(0, 5, 'Jumlah Mutu : ' . number_format($data->jumlah_mutu, 0), 1, 1, 'C');
        $this->pdf->Cell(160, 5, '', 0, 0, 'R');
        $this->pdf->Cell(0, 5, 'IPK : ' . number_format($data->ipk, 2), 1, 1, 'C');
        // space
        $this->pdf->Cell(0, 5, '', 0, 1, 'C');
        $this->pdf->Cell(140, 5, 'JUDUL KARYA TULIS ILMIAH', 1, 0, 'C');
        $this->pdf->Cell(25, 5, 'NILAI', 1, 0, 'C');
        $this->pdf->Cell(0, 5, 'LAMBANG', 1, 1, 'C');
        $this->pdf->Cell(140, 5, $data->transkrip->karya_tulis, 1, 0, 'L');
        $this->pdf->Cell(25, 5, bobot_mutu($data->transkrip->lambang), 1, 0, 'C');
        $this->pdf->Cell(0, 5, $data->transkrip->lambang, 1, 1, 'C');
        // space
        $this->pdf->Cell(0, 10, '', 0, 1, 'C');
        // signature
        $this->pdf->SetFont('Arial', 'B', '9');
        $this->pdf->Cell(90, 5, 'Mengetahui', 0, 0, 'C');
        $this->pdf->Cell(30, 40, 'Pas Photo 3x4', 1, 0, 'C');
        $this->pdf->Cell(90, 5, $this->config->item('report_city') . ', ' . date('d/m/Y'), 0, 1, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG1TITLE), 0, 0, 'C');
        $this->pdf->Cell(30, 0, '', 0, 0, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG2TITLE), 0, 1, 'C');    
        $this->pdf->Cell(0, 25, '', 0, 1, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG1NAME), 0, 0, 'C');
        $this->pdf->Cell(30, 0, '', 0, 0, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG2NAME), 0, 1, 'C');
        // document title
        $this->pdf->SetTitle('Transkrip Nilai: ' . $data->mahasiswa->nama . ' (' . $data->mahasiswa->nim . ')');
        if ($download_mode) {
            $this->pdf->Output('Transkrip Nilai - ' . $data->mahasiswa->nama . ' (' . $data->mahasiswa->nim . ').pdf', 'D');
        } else {
            $this->pdf->Output('Transkrip Nilai - ' . $data->mahasiswa->nama . ' (' . $data->mahasiswa->nim . ').pdf', 'I');
        }
    }

    public function khs() {
        $krs_id = 0;
        $download_mode = false;
        if ($this->uri->segment(3) == TRUE) {
            $krs_id = $this->uri->segment(3);
        }
        if ($this->uri->segment(4) == TRUE) {
            if ($this->uri->segment(4) == 'download') {
                $download_mode = true;
            }
        }

        $data = $this->krs_model->get_khs_for_reporting($krs_id);
        $ipk = $this->transkrip_model->get_jumlah_ipk_semester($data->krs->semester, $data->mahasiswa->id);

        $this->check_doc_valid_access($data->mahasiswa->nim);

        $this->pdf->SetMargins(10, 50, 10);
        $this->pdf->AddPage();
        // title
        $this->pdf->SetFont('Arial', 'BU', '12');
        $this->pdf->Cell(0, 8, 'KARTU HASIL STUDI', 0, 1, 'C');
        // space
        $this->pdf->Cell(0, 2, '', 0, 1, 'C');
        // document info
        $this->pdf->SetFont('Arial', 'B', '9');
        $this->pdf->Cell(30, 5, 'NIM', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, $data->mahasiswa->nim, 0, 1, 'L');
        $this->pdf->Cell(30, 5, 'Nama', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, $data->mahasiswa->nama, 0, 1, 'L');
        $this->pdf->Cell(30, 5, 'Semester', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, $this->valueToSemesterDisplay($data->krs->semester, null), 0, 1, 'L');
        $this->pdf->Cell(30, 5, 'Tahun Akademik', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, $this->valueToTahunAjaranDisplay($data->krs->tahun), 0, 1, 'L');
        // space
        $this->pdf->Cell(0, 5, '', 0, 1, 'C');
        // table
        $this->pdf->SetFont('Arial', 'B', 8);
        // header
        $this->pdf->Cell(10, 5, 'No', 1, 0, 'C');
        $this->pdf->Cell(90, 5, 'NAMA MATA KULIAH', 1, 0, 'C');
        $this->pdf->Cell(20, 5, 'KODE MK', 1, 0, 'C');
        $this->pdf->Cell(12, 5, 'SKS', 1, 0, 'C');
        $this->pdf->Cell(12, 5, 'NILAI', 1, 0, 'C');
        $this->pdf->Cell(12, 5, 'MUTU', 1, 0, 'C');
        $this->pdf->Cell(12, 5, 'ALPA', 1, 0, 'C');
        $this->pdf->Cell(12, 5, 'IZIN', 1, 0, 'C');
        $this->pdf->Cell(12, 5, 'SAKIT', 1, 1, 'C');
        // data font
        $this->pdf->SetFont('Arial', '', 8);
        // data row
        foreach ($data->row_data as $row) {
            $this->pdf->Cell(10, 5, $row->no, 1, 0, 'C');
            $this->pdf->Cell(90, 5, $row->matakuliah, 1, 0, 'L');
            $this->pdf->Cell(20, 5, $row->kodemk, 1, 0, 'C');
            $this->pdf->Cell(12, 5, $row->sks, 1, 0, 'C');
            $this->pdf->Cell(12, 5, $row->nilai, 1, 0, 'C');
            $this->pdf->Cell(12, 5, $row->mutu, 1, 0, 'C');
            $this->pdf->Cell(12, 5, $row->alpa, 1, 0, 'C');
            $this->pdf->Cell(12, 5, $row->izin, 1, 0, 'C');
            $this->pdf->Cell(12, 5, $row->sakit, 1, 1, 'C');
        }
        // space
        $this->pdf->Cell(0, 5, '', 0, 1, 'C');
        // document footer
        $this->pdf->SetFont('Arial', 'B', '9');
        $this->pdf->Cell(110, 5, '', 0, 0, 'L');
        $this->pdf->Cell(50, 5, 'Jumlah Mutu', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, number_format($data->jumlah_mutu, 0), 0, 1, 'L');
        $this->pdf->Cell(110, 5, '', 0, 0, 'L');
        $this->pdf->Cell(50, 5, 'Jumlah SKS', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, number_format($data->jumlah_sks, 0), 0, 1, 'L');
        $this->pdf->Cell(110, 5, '', 0, 0, 'L');
        $this->pdf->Cell(50, 5, 'Indeks Prestasi Semester', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, number_format($data->ips, 2), 0, 1, 'L');
        $this->pdf->Cell(110, 5, '', 0, 0, 'L');
        $this->pdf->Cell(50, 5, 'IPK Sementara', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, number_format($ipk, 2), 0, 1, 'L');
        // space
        $this->pdf->Cell(0, 15, '', 0, 1, 'C');
        // signature
        $this->pdf->SetFont('Arial', 'B', '9');
        $this->pdf->Cell(90, 5, 'Mengetahui', 0, 0, 'C');
        $this->pdf->Cell(90, 5, $this->config->item('report_city') . ', ' . date('d/m/Y'), 0, 1, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG1TITLE), 0, 0, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG2TITLE), 0, 1, 'C');
        $this->pdf->Cell(0, 20, '', 0, 1, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG1NAME), 0, 0, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG2NAME), 0, 1, 'C');
        // document title
        $this->pdf->SetTitle('KHS: ' . $data->mahasiswa->nama . ' (' . $data->mahasiswa->nim . ')');
        if ($download_mode) {
            $this->pdf->Output('KHS - ' . $data->mahasiswa->nama . ' (' . $data->mahasiswa->nim . ').pdf', 'D');
        } else {
            $this->pdf->Output('KHS - ' . $data->mahasiswa->nama . ' (' . $data->mahasiswa->nim . ').pdf', 'I');
        }
    }
    
    public function kps() {
        $kps_id = 0;
        $download_mode = false;
        if ($this->uri->segment(3) == TRUE) {
            $kps_id = $this->uri->segment(3);
        }
        if ($this->uri->segment(4) == TRUE) {
            if ($this->uri->segment(4) == 'download') {
                $download_mode = true;
            }
        }

        $data = $this->krs_model->get_khs_for_reporting($kps_id);
        $ipk = $this->transkrip_model->get_jumlah_ipk_semester($data->krs->semester, $data->mahasiswa->id);
        $sks_lulus = $this->transkrip_model->get_jumlah_sks_lulus_by_mahasiswa($data->mahasiswa->id, $data->krs->semester);

        $this->check_doc_valid_access($data->mahasiswa->nim);

        $this->pdf->SetMargins(10, 50, 10);
        $this->pdf->AddPage();
        // title
        $this->pdf->SetFont('Arial', 'BU', '12');
        $this->pdf->Cell(0, 8, 'KARTU PROGRAM STUDI (KPS)', 0, 1, 'C');
        // space
        $this->pdf->Cell(0, 2, '', 0, 1, 'C');
        // document info
        $this->pdf->SetFont('Arial', 'B', '9');        
        $this->pdf->Cell(50, 5, 'Nama Mahasiswa', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(50, 5, $data->mahasiswa->nama, 0, 1, 'L');
        $this->pdf->Cell(50, 5, 'Nomor Induk Mahasiswa (NIM)', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(50, 5, $data->mahasiswa->nim, 0, 1, 'L');
        $this->pdf->Cell(50, 5, 'Angkatan / Tahun', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(50, 5, $data->mahasiswa->tahun, 0, 1, 'L');
        $this->pdf->Cell(50, 5, 'Semester', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(50, 5, $this->valueToSemesterDisplay($data->krs->semester, null), 0, 0, 'L');
        $this->pdf->Cell(50, 5, 'Tahun Akademik', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(50, 5, $this->valueToTahunAjaranDisplay($data->krs->tahun), 0, 1, 'L');
        $this->pdf->Cell(50, 5, 'Jumlah SKS Yang Lulus', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(50, 5, $this->valueToSksDisplay($sks_lulus), 0, 1, 'L');
        // space
        $this->pdf->Cell(0, 5, '', 0, 1, 'C');
        // table
        $this->pdf->SetFont('Arial', 'B', 8);
        // header
        $this->pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $this->pdf->Cell(20, 10, 'KODE MA', 1, 0, 'C');
        $this->pdf->Cell(100, 10, 'NAMA MATA KULIAH', 1, 0, 'C');        
        $this->pdf->Cell(12, 10, 'SKS', 1, 0, 'C');
        $this->pdf->Cell(50, 10, 'DOSEN PENGAMPU', 1, 1, 'C');       
        // data font
        $this->pdf->SetFont('Arial', '', 8);
        // data row
        foreach ($data->row_data as $row) {
            $this->pdf->Cell(10, 10, $row->no, 1, 0, 'C');
            $this->pdf->Cell(20, 10, $row->kodemk, 1, 0, 'C');
            $this->pdf->Cell(100, 10, $row->matakuliah, 1, 0, 'L');            
            $this->pdf->Cell(12, 10, $row->sks, 1, 0, 'C');
            $this->pdf->Cell(50, 10, '', 1, 1, 'C');            
        }
        // space
        $this->pdf->Cell(0, 5, '', 0, 1, 'C');
        // document footer
        $this->pdf->SetFont('Arial', 'B', '9');
        $this->pdf->Cell(110, 5, '', 0, 0, 'L');
        $this->pdf->Cell(50, 5, 'Jumlah Mutu', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, number_format($data->jumlah_mutu, 0), 0, 1, 'L');
        $this->pdf->Cell(110, 5, '', 0, 0, 'L');
        $this->pdf->Cell(50, 5, 'Jumlah SKS', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, number_format($data->jumlah_sks, 0), 0, 1, 'L');
        $this->pdf->Cell(110, 5, '', 0, 0, 'L');
        $this->pdf->Cell(50, 5, 'Indeks Prestasi Semester', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, number_format($data->ips, 2), 0, 1, 'L');
        $this->pdf->Cell(110, 5, '', 0, 0, 'L');
        $this->pdf->Cell(50, 5, 'IPK Sementara', 0, 0, 'L');
        $this->pdf->Cell(5, 5, ':', 0, 0, 'C');
        $this->pdf->Cell(0, 5, number_format($ipk, 2), 0, 1, 'L');
        // space
        $this->pdf->Cell(0, 15, '', 0, 1, 'C');
        // signature
        $this->pdf->SetFont('Arial', 'B', '9');
        $this->pdf->Cell(90, 5, 'Mengetahui', 0, 0, 'C');
        $this->pdf->Cell(90, 5, $this->config->item('report_city') . ', ' . date('d/m/Y'), 0, 1, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG1TITLE), 0, 0, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG2TITLE), 0, 1, 'C');
        $this->pdf->Cell(0, 20, '', 0, 1, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG1NAME), 0, 0, 'C');
        $this->pdf->Cell(90, 5, $this->config_model->get($this->config_model->_SIG2NAME), 0, 1, 'C');
        // document title
        $this->pdf->SetTitle('KHS: ' . $data->mahasiswa->nama . ' (' . $data->mahasiswa->nim . ')');
        if ($download_mode) {
            $this->pdf->Output('KHS - ' . $data->mahasiswa->nama . ' (' . $data->mahasiswa->nim . ').pdf', 'D');
        } else {
            $this->pdf->Output('KHS - ' . $data->mahasiswa->nama . ' (' . $data->mahasiswa->nim . ').pdf', 'I');
        }
    }

}

/* End of file doc.php */
/* Location: ./application/controllers/doc.php */