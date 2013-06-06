<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Krs Model
 * 
 * File: krs_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
 */
class Krs_model extends MY_Model {

    protected $_table_name = "krs";

    function __construct() {
        // Call the Model constructor
        parent::__construct();

        $this->load->helper('nilai_helper');
    }

    function get_nilai_krs($id) {
        $this->db->where('krs', $id);
        $data = $this->db->get('krsdetail')->result();

        $jumlah_sks = $this->get_jumlah_sks_krs($id);
        $jumlah_mutu = $this->get_jumlah_mutu_krs($id);


        if ($jumlah_sks > 0) {
            return $jumlah_mutu / $jumlah_sks;
        } else {
            return 0;
        }
    }

    function get_jumlah_sks_krs($id) {
        $jumlah_sks = 0;
        $this->db->where('krs', $id);
        $data = $this->db->get('krsdetail')->result();
        foreach ($data as $value) {
            $matakuliah = $this->db->get_where('matakuliah', array($this->_primary_key => $value->matakuliah))->row();
            $jumlah_sks = $jumlah_sks + $matakuliah->kredit;
        }
        return $jumlah_sks;
    }

    function get_jumlah_mutu_krs($id) {
        $jumlah_mutu = 0;
        $this->db->where('krs', $id);
        $data = $this->db->get('krsdetail')->result();
        foreach ($data as $value) {
            $matakuliah = $this->db->get_where('matakuliah', array($this->_primary_key => $value->matakuliah))->row();
            $jumlah_mutu = $jumlah_mutu + (bobot_mutu(nilai_bobot($value->nilai)) * $matakuliah->kredit);
        }
        return $jumlah_mutu;
    }

    function get_jumlah_ips_krs($id) {
        $jumlah_sks = $this->get_jumlah_sks_krs($id);
        $jumlah_mutu = $this->get_jumlah_mutu_krs($id);
        if ($jumlah_sks > 0) {
            return $jumlah_mutu / $jumlah_sks;
        } else {
            return 0;
        }
    }

    function get_khs_for_reporting($id) {
        $krs = $this->db->get_where($this->_table_name, array($this->_primary_key => $id))->row();

        $mahasiswa = $this->db->get_where('mahasiswa', array($this->_primary_key => $krs->mahasiswa))->row();
        $detail = $this->db->get_where('krsdetail', array('krs' => $krs->id))->result();

        $i = 1;
        $row_data = array();
        foreach ($detail as $value) {
            $matakuliah = $this->db->get_where('matakuliah', array($this->_primary_key => $value->matakuliah))->row();
            $row = array(
                'no' => $i,
                'matakuliah' => $matakuliah->nama,
                'kodemk' => $matakuliah->kode,
                'sks' => $matakuliah->kredit,
                'nilai' => nilai_bobot($value->nilai),
                'mutu' => $matakuliah->kredit * bobot_mutu(nilai_bobot($value->nilai)),
                'alpa' => $value->alpa,
                'izin' => $value->izin,
                'sakit' => $value->sakit
            );
            array_push($row_data, (object) $row);
            $i++;
        }

        return (object) array('krs' => $krs, 'row_data' => (object) $row_data,
                    'mahasiswa' => $mahasiswa, 'jumlah_sks' => $this->get_jumlah_sks_krs($id),
                    'jumlah_mutu' => $this->get_jumlah_mutu_krs($id),
                    'ips' => $this->get_jumlah_ips_krs($id)
                );
    }

}

/* End of file krs_model.php */
/* Location: ./application/controllers/krs_model.php */