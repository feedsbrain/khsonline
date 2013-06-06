<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MY_Model
 * This is default Model for KHS Online application
 * 
 * File: MY_Model.php
 * 
 * @package application/core
 * @author Indra <indra@indragunawan.com>
 */
class MY_Model extends CI_Model {

    protected $_primary_key = "id";
    protected $_table_name = "null";
    protected $_default_order = "asc";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function getAll() {
        $query = $this->db->get($this->_table_name);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_paged_list($limit = 10, $offset = 0, $order_column = '', $order_type = '') {
        if (empty($order_type)) {
            $order_type = $this->_default_order;
        }
        if (empty($order_column)) {
            $this->db->order_by($this->_primary_key, $this->_default_order);
        } else {
            $this->db->order_by($order_column, $order_type);
        }
        return $this->db->get($this->_table_name, $limit, $offset);
    }

    function count_all() {
        return $this->db->count_all($this->_table_name);
    }

    function get_by_id($id) {
        $this->db->where($this->_primary_key, $id);
        return $this->db->get($this->_table_name);
    }

    function save($instance) {
        $this->db->insert($this->_table_name, $instance);
        return $this->db->insert_id();
    }

    function update($id, $instance) {
        $this->db->where($this->_primary_key, $id);
        $this->db->update($this->_table_name, $instance);
    }

    function delete($id) {
        $this->db->where($this->_primary_key, $id);
        $this->db->delete($this->_table_name);
    }

}

/* End of file MY_Model.php */
/* Location: ./application/controllers/MY_Model.php */