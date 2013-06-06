<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Users Model
 * 
 * File: users_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
 */
class Users_model extends MY_Model {

    protected $_table_name = "users";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function init_login() {
        if ($this->count_all() == 0) {
            $this->load->helper('security');
            $data = array(
                'id' => NULL,
                'username' => 'admin',
                'password' => do_hash('admin', 'md5'),
                'level' => 'A',
                'name' => 'Administrator',
                'email' => 'admin@changeme.com',
                'active' => true,
                'system' => true
            );
            $query = $this->db->insert_string('users', $data);
            $this->db->query($query);
        }
    }

    public function count_all() {
        return $this->db->count_all($this->_table_name);
    }

    public function do_login($username, $password) {
        $this->load->helper('security');
        $hash_password = do_hash($password, 'md5');

        $this->db->select('id, username, password, level, name, email, active, system');
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->where('password', $hash_password);
        $this->db->where('active', true);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function update_password($username, $password) {
        $this->load->helper('security');
        $hash_password = do_hash($password, 'md5');

        $this->db->where('username', $username);
        $this->db->update($this->_table_name, array('password' => $hash_password));
    }

    public function update_informasi($username, $instance) {
        $this->db->where('username', $username);
        $this->db->update($this->_table_name, $instance);
    }

    function get_by_username($username) {
        $this->db->where('username', $username);
        return $this->db->get($this->_table_name);
    }

}

/* End of file users_model.php */
/* Location: ./application/controllers/users_model.php */