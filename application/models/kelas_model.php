<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kelas_model
 *
 * @author Indra
 */
class Kelas_model extends MY_Model {

    protected $_table_name = "kelas";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

}

/* End of file kelas_model.php */
/* Location: ./application/controllers/kelas_model.php */