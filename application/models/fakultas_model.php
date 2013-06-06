<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fakultas_model
 *
 * @author Indra
 */
class Fakultas_model extends MY_Model {

    protected $_table_name = "fakultas";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

}

/* End of file fakultas_model.php */
/* Location: ./application/controllers/fakultas_model.php */