<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Matakuliah Model
 * 
 * File: matakuliah_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
 */
class Matakuliah_model extends MY_Model {

    protected $_table_name = "matakuliah";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function populate_for_dropdown() {
        $sql = "SELECT mk.id, CONCAT(mk.nama,' (',mk.kode,')') AS 'nama' 
            FROM matakuliah mk ORDER BY mk.nama, mk.semester";
        $query = $this->db->query($sql);
        $dropdowns = $query->result();
        foreach ($dropdowns as $dropdown) {
            $dropDownList[$dropdown->id] = $dropdown->nama;
        }
        $finalDropDown = $dropDownList;
        return $finalDropDown;
    }

}

/* End of file matakuliah_model.php */
/* Location: ./application/controllers/matakuliah_model.php */