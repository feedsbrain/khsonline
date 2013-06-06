<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Config Model
 * 
 * File: config_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
 */
class Config_model extends MY_Model {

    protected $_table_name = "config";
    
    public $_SIG1TITLE = "SIG1TITLE";
    public $_SIG1NAME = "SIG1NAME";
    public $_SIG2TITLE = "SIG2TITLE";
    public $_SIG2NAME = "SIG2NAME";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function set($key, $value) {
        $config = $this->get($key);
        if ($config != null) {
            $data = array(
                'value' => $value
            );
            $this->db->where('key', $key);
            $this->db->update($this->_table_name, $data);
        } else {
            $data = array(
                'key' => $key,
                'value' => $value
            );
            $this->db->insert($this->_table_name, $data);
        }
    }

    public function get($key) {
        $config = (object) $this->db->get_where($this->_table_name, array('key' => $key), 1)->row();
        return $config->value;
    }

}

/* End of file config_model.php */
/* Location: ./application/controllers/config_model.php */