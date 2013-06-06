<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author Indra
 */
class Login extends MY_Controller {

    protected $_title = 'KHS Online';
    protected $_page_name = 'User Login';

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
        $this->load->helper(array('form'));
        $this->load->model('users_model');
        $this->load->helper('captcha');

        $this->set_active_module('login', 'login');
        $this->set_active_view('login');
    }

    function index() {
        $this->users_model->init_login();
        $this->_page_output((object) $this->_blank_vars);
    }

    protected function _page_output($output = null) {
        $vals = array(
            'img_path' => './assets/captcha/',
            'img_url' => base_url() . 'assets/captcha/',
            'img_width' => 100,
            'img_height' => 25,
            'expiration' => 60,
            'word' => random_string('numeric', 6)
        );
        $cap = create_captcha($vals);
        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
        );
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);

        $output->title = $this->_title;
        $output->page_name = $this->_page_name;
        $output->main_menu = $this->_populate_main_menu();
        $output->side_menu = $this->_populate_side_menu();
        $output->cap = $cap;
        $this->_load_theme_and_view($output);
    }

    public function perform() {
        //This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
        $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|xss_clean|callback_check_captcha');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->_page_output((object) $this->_blank_vars);
        } else {
            //Go to private area
            if ($this->session->userdata('logged_in')) {
                $session_data = $this->session->userdata('logged_in');
                $level = $session_data['level'];
                if ($level == 'A' || $level == 'D') {
                    redirect('backoffice', 'refresh');
                } else {
                    redirect('main', 'refresh');
                }
            } else {
                //If no session, redirect to login page
                redirect('login', 'refresh');
            }
        }
    }

    function check_captcha($captcha) {
        // First, delete old captchas
        $expiration = time() - 60; // 1 minute limit
        $this->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);

        // Then see if a captcha exists:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count == 0) {
            $this->form_validation->set_message('check_captcha', 'Captcha yang anda masukan salah atau sudah kadaluarsa');
            return false;
        }

        return TRUE;
    }

    function check_database($password) {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');

        //query the database
        $result = $this->users_model->do_login($username, $password);

        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'id' => $row->id,
                    'username' => $row->username,
                    'name' => $row->name,
                    'email' => $row->email,
                    'level' => $row->level,
                    'active' => $row->active,
                    'system' => $row->system
                );
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Username sudah tidak aktif atau password anda salah');
            return false;
        }
    }

    function do_logout() {
        if ($this->session->userdata('logged_in')) {
            $this->session->unset_userdata('logged_in');
            $this->session->sess_destroy();
        }
        redirect('login', 'refresh');
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */