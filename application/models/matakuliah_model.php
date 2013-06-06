<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of matakuliah_model
 *
 * @author Indra
 */
class Matakuliah_model extends MY_Model {

    protected $_table_name = "matakuliah";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

}

/* End of file matakuliah_model.php */
/* Location: ./application/controllers/matakuliah_model.php */