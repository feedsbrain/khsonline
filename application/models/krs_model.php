<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of krs_model
 *
 * @author Indra
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

}

/* End of file krs_model.php */
/* Location: ./application/controllers/krs_model.php */