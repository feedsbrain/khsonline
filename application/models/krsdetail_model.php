<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Krsdetail Model
 * 
 * File: krsdetail_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
 */
class Krsdetail_model extends MY_Model {

    protected $_table_name = "krsdetail";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_detail_for_penilaian($tahun, $semester, $matakuliah_id) {
        $sql = "SELECT kd.id, k.tahun, k.semester, mk.kode AS 'kode', 
            mk.nama AS 'matakuliah', j.nama AS 'jurusan', m.nama as 'mahasiswa', 
            kl.nama as 'kelas', kd.nilai, kd.alpa, kd.izin, kd.sakit 
            FROM krsdetail kd INNER JOIN krs k ON kd.krs = k.id 
            INNER JOIN matakuliah mk ON kd.matakuliah = mk.id 
            INNER JOIN mahasiswa m ON k.mahasiswa = m.id 
            INNER JOIN kelas kl ON m.kelas = kl.id 
            INNER JOIN jurusan j ON kl.jurusan = j.id 
            WHERE k.posted = TRUE AND mk.id = " . $matakuliah_id .
                " AND k.tahun = " . $tahun . " AND k.semester = " . $semester .
                " ORDER BY m.kelas, m.nama;";

        $penilaian = $this->db->query($sql)->result();

        $row = 1;
        foreach ($penilaian as $data) {
            $data->no = $row;
            $row++;
        }

        return $penilaian;
    }

}

/* End of file krsdetail_model.php */
/* Location: ./application/controllers/krsdetail_model.php */