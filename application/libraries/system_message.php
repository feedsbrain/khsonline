<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of system_message
 *
 * @author Indra
 */
class System_message {

    public $system_messages = array();

    function __construct() {
        $this->system_messages = array();
    }

    function warning($msg = '') {
        return '<p class="msg warning">' . $msg . '</p>';
    }

    function info($msg = '') {
        return '<p class="msg info">' . $msg . '</p>';
    }

    function success($msg = '') {
        return '<p class="msg done">' . $msg . '</p>';
    }

    function error($msg = '') {
        return '<p class="msg error">' . $msg . '</p>';
    }
    
    function clear() {
        $this->system_messages = array();
    }

    function add($msg, $type = 'info') {
        $value = '';
        switch ($type) {
            case 'info':
                $value = $this->info($msg);
                break;
            case 'warning':
                $value = $this->warning($msg);
                break;
            case 'success':
                $value = $this->success($msg);
                break;
            case 'error':
                $value = $this->error($msg);
                break;
            default:
                break;
        }       
        array_push($this->system_messages, $value);
    }

    function get_messages() {
        $string_buffer = '';
        foreach ($this->system_messages as $value) {
            $string_buffer = $value;
        }
        return $string_buffer;
    }

}

/* End of file system_message.php */
/* Location: ./application/libraries/system_message.php */
