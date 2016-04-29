<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Multipledb {

    var $db = NULL;

    function __construct() {
        $CI = &get_instance();
        $this->db = $CI->load->database('db2', TRUE);
    }

    // Add more functions two use commonly.
    public function save() {
        
    }

}
