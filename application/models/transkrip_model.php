<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Transkrip Model
 * 
 * File: transkrip_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
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

    function get_transkrip_by_mahasiswa($mahasiswa_id, $limit_semester = null) {
        $sql = "SELECT mk.kode AS 'kode', mk.nama AS 'nama', mk.kredit AS 'sks', MAX(kd.nilai) AS 'nilai' 
            FROM krs k INNER JOIN krsdetail kd ON kd.krs = k.id INNER JOIN matakuliah mk ON kd.matakuliah = mk.id
            WHERE k.mahasiswa = " . $mahasiswa_id . " GROUP BY mk.kode, mk.nama, mk.kredit ORDER BY mk.semester, mk.nama";

        if ($limit_semester != null && $limit_semester > 0) {
            $sql = "SELECT mk.kode AS 'kode', mk.nama AS 'nama', mk.kredit AS 'sks', MAX(kd.nilai) AS 'nilai' 
            FROM krs k INNER JOIN krsdetail kd ON kd.krs = k.id INNER JOIN matakuliah mk ON kd.matakuliah = mk.id
            WHERE k.mahasiswa = " . $mahasiswa_id . " AND k.semester <= " . $limit_semester .
                    " GROUP BY mk.kode, mk.nama, mk.kredit ORDER BY mk.semester, mk.nama";
        }

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

    function get_jumlah_sks_transkrip_by_mahasiswa($mahasiswa_id, $limit_semester = null) {
        $jumlah_sks = 0;
        $data = $this->get_transkrip_by_mahasiswa($mahasiswa_id, $limit_semester);
        foreach ($data as $value) {
            $jumlah_sks = $jumlah_sks + $value->sks;
        }
        return $jumlah_sks;
    }

    function get_jumlah_mutu_transkrip_by_mahasiswa($mahasiswa_id, $limit_semester = null) {
        $jumlah_mutu = 0;
        $data = $data = $this->get_transkrip_by_mahasiswa($mahasiswa_id, $limit_semester);
        foreach ($data as $value) {
            $jumlah_mutu = $jumlah_mutu + ($value->mutu * $value->sks);
        }
        return $jumlah_mutu;
    }

    function get_jumlah_ipk($mahasiswa_id) {
        $jumlah_sks = $this->get_jumlah_sks_transkrip_by_mahasiswa($mahasiswa_id);
        $jumlah_mutu = $this->get_jumlah_mutu_transkrip_by_mahasiswa($mahasiswa_id);
        if ($jumlah_sks > 0) {
            return $jumlah_mutu / $jumlah_sks;
        } else {
            return 0;
        }
    }

    function get_jumlah_ipk_semester($semester, $mahasiswa_id) {
        $jumlah_sks = $this->get_jumlah_sks_transkrip_by_mahasiswa($mahasiswa_id, $semester);
        $jumlah_mutu = $this->get_jumlah_mutu_transkrip_by_mahasiswa($mahasiswa_id, $semester);
        if ($jumlah_sks > 0) {
            return $jumlah_mutu / $jumlah_sks;
        } else {
            return 0;
        }
    }
    
    function get_jumlah_sks_lulus_by_mahasiswa($mahasiswa_id, $limit_semester = null) {
        $jumlah_sks = 0;
        $data = $this->get_transkrip_by_mahasiswa($mahasiswa_id, $limit_semester);
        foreach ($data as $value) {
            if ($value->mutu > 0) {
                $jumlah_sks = $jumlah_sks + $value->sks;
            }
        }
        return $jumlah_sks;
    }

    function get_transkrip_for_reporting($id) {
        $transkrip = $this->get_by_id($id)->row();

        $mahasiswa = $this->db->get_where('mahasiswa', array($this->_primary_key => $transkrip->mahasiswa))->row();
        $data = $this->get_transkrip_by_mahasiswa($mahasiswa->id);

        $i = 1;
        $row_data = array();
        foreach ($data as $value) {
            $row = array(
                'no' => $i,
                'matakuliah' => $value->nama,
                'kodemk' => $value->kode,
                'sks' => $value->sks,
                'nilai' => $value->nilai,
                'mutu' => $value->sks * $value->mutu
            );
            array_push($row_data, (object) $row);
            $i++;
        }
        return (object) array('transkrip' => $transkrip, 'row_data' => (object) $row_data,
                    'mahasiswa' => $mahasiswa, 'jumlah_sks' => $this->get_jumlah_sks_transkrip_by_mahasiswa($mahasiswa->id),
                    'jumlah_mutu' => $this->get_jumlah_mutu_transkrip_by_mahasiswa($mahasiswa->id),
                    'ipk' => $this->get_jumlah_ipk($mahasiswa->id)
                );
    }

}

/* End of file transkrip_model.php */
/* Location: ./application/controllers/transkrip_model.php */