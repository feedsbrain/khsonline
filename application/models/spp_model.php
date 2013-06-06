<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Spp Model
 * 
 * File: spp_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
 */
class Spp_model extends MY_Model {

    protected $_table_name = "spp";
    protected $_table_detail_name = "sppdetail";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_detail_sum($id) {
        $this->db->where('spp', $id);
        $this->db->select_sum('jumlah');
        return $this->db->get($this->_table_detail_name)->row()->jumlah; 
    }

}

/* End of file spp_model.php */
/* Location: ./application/controllers/spp_model.php */