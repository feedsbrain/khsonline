<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Kelas Model
 * 
 * File: kelas_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
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