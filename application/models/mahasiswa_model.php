<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mahasiswa_model
 *
 * @author Indra
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