<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Mahasiswa Model
 * 
 * File: mahasiswa_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
 */
class Mahasiswa_model extends MY_Model {

    protected $_table_name = "mahasiswa";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_by_nim($nim) {
        $this->db->where('nim', $nim);
        return $this->db->get($this->_table_name);
    }

}

/* End of file mahasiswa_model.php */
/* Location: ./application/controllers/mahasiswa_model.php */