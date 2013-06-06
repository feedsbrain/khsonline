<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of error
 *
 * @author Indra
 */
class Error extends CI_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
    }

    function index() {
        $this->_page_output((object) $this->_blank_vars);
    }

}

/* End of file error.php */
/* Location: ./application/controllers/error.php */