<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of informasi
 *
 * @author Indra
 */
class Informasi extends MY_Controller {

    protected $_title = 'Update Informasi';
    protected $_page_name = 'Informasi User';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->set_active_module('backoffice', 'konfigurasi');
        $this->set_active_view('informasi');

        $this->load->helper(array('form'));
        $this->load->model('users_model');        
    }

    private function __populate_data() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $username = $session_data['username'];

            $user_instance = $this->users_model->get_by_username($username)->row();
            $output = (object) $this->_blank_vars;
            $output->name = $user_instance->name;
            $output->email = $user_instance->email;
            return $output;
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function index() {
        $output = $this->__populate_data();
        $this->_page_output($output);
    }

    public function change_informasi_success() {
        //Field validation failed. 
        $output = $this->__populate_data();
        $output->success_message = 'Informasi berhasil diupdate!';
        $this->_page_output($output);
    }

    public function do_change_informasi() {
        if ($this->session->userdata('logged_in')) {

            //This method will have the credentials validation
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'Nama', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'E-Mail', 'trim|required|xss_clean|valid_email');

            if ($this->form_validation->run() == FALSE) {
                //Field validation failed. 
                $this->_page_output((object) $this->_blank_vars);
            } else {
                $session_data = $this->session->userdata('logged_in');
                $username = $session_data['username'];

                $informasi = array('name' => $this->input->post('name'), 'email' => $this->input->post('email'));
                $this->users_model->update_informasi($username, $informasi);
                redirect('informasi/change_informasi_success', 'refresh');
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

}

/* End of file informasi.php */
/* Location: ./application/controllers/informasi.php */