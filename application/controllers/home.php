<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url'); 
        $this->load->library('pagination'); 
        $this->load->helper('cookie');
        $this->load->helper('text'); 
        $this->load->helper(array('form', 'url')); 
        $this->load->helper(array('javelin'));
        $this->load->helper(array('slug')); 
        date_default_timezone_set('UTC');
    }

    public function index( ) {  
        
        $this->load->view('home/index');
    }
    
    public function details(){
        $this->load->view('home/index');
    }

}
