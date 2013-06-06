<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jurusan_model
 *
 * @author Indra
 */
class Jurusan_model extends MY_Model {

    protected $_table_name = "jurusan";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

}

/* End of file jurusan_model.php */
/* Location: ./application/controllers/jurusan_model.php */