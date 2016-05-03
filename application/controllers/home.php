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

    public function index() {  
        $this->load->model('cate_model');
        $this->load->model('content_model');
        $data['']= $this->content_model->load_news_post_slide();
        $data['lastest_post'] = $this->content_model->load_lastest_post();
        $data['list_categories'] = $this->cate_model->list_category();
        $data['get_new_post_slide'] = $this->content_model->load_newpost_slide();
         
        $this->load->view('home/index',$data);
    }
    
    public function ajax_content(){
        $this->load->model('homecate_model');
        $data['list_homecate'] = $this->homecate_model->list_home_cate();
    }
    
    public function details($id){
        $this->load->view('home/index');
    }
    
    public function category($id){
        $this->load->view('home/index');
    }

}
