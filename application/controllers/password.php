<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of password
 *
 * @author Indra
 */
class Password extends MY_Controller {

    protected $_title = 'Ganti Password';
    protected $_page_name = 'User Password';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'konfigurasi');
        $this->set_active_view('password');

        $this->load->helper(array('form'));
        $this->load->model('users_model');
    }

    function index() {
        $this->_page_output((object) $this->_blank_vars);
    }

    public function change_password_success() {
        //Field validation failed. 
        $output = (object) $this->_blank_vars;
        $output->success_message = 'Password berhasil diganti, silahkan logout untuk mencoba password baru!';
        $this->_page_output($output);
    }

    public function do_change_password() {
        if ($this->session->userdata('logged_in')) {

            //This method will have the credentials validation
            $this->load->library('form_validation');

            $this->form_validation->set_rules('old_password', 'Password Lama', 'trim|required|xss_clean|callback_check_password');
            $this->form_validation->set_rules('new_password', 'Password Baru', 'trim|required|xss_clean|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //Field validation failed. 
                $this->_page_output((object) $this->_blank_vars);
            } else {
                $session_data = $this->session->userdata('logged_in');
                $username = $session_data['username'];

                $new_password = $this->input->post('new_password');
                $this->users_model->update_password($username, $new_password);
                redirect('password/change_password_success', 'refresh');
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function check_password($password) {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $username = $session_data['username'];

            //query the database
            $result = $this->users_model->do_login($username, $password);

            if (!$result) {
                $this->form_validation->set_message('check_password', 'Password lama salah');
                return false;
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
        return TRUE;
    }

}

/* End of file password.php */
/* Location: ./application/controllers/password.php */