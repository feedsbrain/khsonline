<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of doc
 *
 * @author Indra
 */
class Doc extends CI_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();

        $this->load->library('pdf'); // Load library
        $this->pdf->fontpath = 'assets/font/'; // Specify font folder
    }

    public function index() {
        // Generate PDF by saying hello to the world
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(40, 10, 'Hello World!');
        $this->pdf->Output();
    }

}

/* End of file doc.php */
/* Location: ./application/controllers/doc.php */