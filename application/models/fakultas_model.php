<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Fakultas Model
 * 
 * File: fakultas_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
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