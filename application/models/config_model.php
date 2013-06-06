<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config_model
 *
 * @author Indra
 */
class Config_model extends MY_Model {

    protected $_table_name = "config";

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
        $this->db->where('key', $key);
        $this->db->select('value');
        $query = $this->db->get($this->_table_name, 1);
        if (!is_null($query)) {
            return $query->value;
        } else {
            return null;
        }
    }

}

/* End of file config_model.php */
/* Location: ./application/controllers/config_model.php */