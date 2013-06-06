<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Jurusan Model
 * 
 * File: jurusan_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
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