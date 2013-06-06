<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('nilai_bobot')) {

    function nilai_bobot($nilai) {
        if ($nilai >= 79) {
            return 'A';
        } else if ($nilai >= 68) {
            return 'B';
        } else if ($nilai >= 58) {
            return 'C';
        } else if ($nilai >= 41) {
            return 'D';
        } else if ($nilai >= 1) {
            return 'E';
        }
        return '-';
    }

}

if (!function_exists('bobot_mutu')) {

    function bobot_mutu($bobot) {
        switch ($bobot) {
            case 'A':
                return 4;
                break;
            case 'B':
                return 3;
                break;
            case 'C':
                return 2;
                break;
            case 'D':
                return 1;
                break;
            default:
                return 0;
                break;
        }
    }

}

/* End of file nilai_helper.php */
/* Location: ./application/helpers/nilai_helper.php */