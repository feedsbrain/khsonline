<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transkrip_model
 *
 * @author Indra
 */
class Transkrip_model extends MY_Model {

    protected $_table_name = "transkrip";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_by_mahasiswa($mahasiswa_id) {
        $this->db->where('mahasiswa', $mahasiswa_id);
        return $this->db->get($this->_table_name);
    }

    function get_transkrip_by_mahasiswa($mahasiswa_id) {
        $sql = "SELECT mk.kode AS 'kode', mk.nama AS 'nama', mk.kredit AS 'sks', MAX(kd.nilai) AS 'nilai' 
            FROM krs k INNER JOIN krsdetail kd ON kd.krs = k.id INNER JOIN matakuliah mk ON kd.matakuliah = mk.id
            WHERE k.mahasiswa = " . $mahasiswa_id . " GROUP BY mk.kode, mk.nama, mk.kredit ORDER BY mk.semester, mk.nama";

        $transkrip = $this->db->query($sql)->result();

        $row = 1;
        foreach ($transkrip as $data) {
            $data->no = $row;
            $data->nilai = nilai_bobot($data->nilai);
            $data->mutu = bobot_mutu($data->nilai);
            $row++;
        }

        return $transkrip;
    }

    function get_jumlah_sks_transkrip_by_mahasiswa($mahasiswa_id) {
        $jumlah_sks = 0;
        $data = $this->get_transkrip_by_mahasiswa($mahasiswa_id);
        foreach ($data as $value) {
            $jumlah_sks = $jumlah_sks + $value->sks;
        }
        return $jumlah_sks;
    }

    function get_jumlah_mutu_transkrip_by_mahasiswa($mahasiswa_id) {
        $jumlah_mutu = 0;
        $data = $data = $this->get_transkrip_by_mahasiswa($mahasiswa_id);
        foreach ($data as $value) {
            $jumlah_mutu = $jumlah_mutu + ($value->mutu * $value->sks);
        }
        return $jumlah_mutu;
    }

}

/* End of file transkrip_model.php */
/* Location: ./application/controllers/transkrip_model.php */