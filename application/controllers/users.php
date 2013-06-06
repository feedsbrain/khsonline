<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Users Controller
 * 
 * File: users.php
 * 
 * @package application/controllers
 * @author Indra <indra@indragunawan.com>
 */
class Users extends MY_Controller {
    
    protected $_valid_access = array('A');

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'konfigurasi');
        $this->set_active_view('users');
    }

    function index() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('users');
            $crud->set_subject('Users');
            $crud->required_fields('username', 'name', 'password', 'level', 'email', 'active');
            $crud->columns('username', 'name', 'level', 'email', 'active');
            if ($this->uri->segment(3) == TRUE) {
                if ($this->uri->segment(3) == 'edit') {
                    $crud->fields('username', 'name', 'level', 'email', 'active');
                }
            } else {
                $crud->fields('username', 'name', 'password', 'level', 'email', 'active');
            }
            $crud->change_field_type('password', 'password');
            $crud->change_field_type('system', 'hidden');
            $crud->callback_before_insert(array($this, 'encrypt_password_callback'));
            $crud->unset_columns('password');
            $crud->unset_edit_fields('password');
            $crud->callback_column('level', array($this, 'valueToCenter'));
            $crud->callback_column('email', array($this, 'valueToCenter'));
            $crud->callback_column('username', array($this, 'valueToCenter'));
            $crud->callback_column('active', array($this, 'valueActiveStatus'));
            $crud->where('system', FALSE);

            $output = $crud->render();

            $this->_page_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function encrypt_password_callback($post_array, $primary_key = null) {
        $this->load->helper('security');
        $post_array['password'] = do_hash($post_array['password'], 'md5');
        return $post_array;
    }

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */