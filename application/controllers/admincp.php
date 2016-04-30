<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admincp extends CI_Controller {

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
        if ($this->session->userdata('admin_id') == null) {
            redirect('admincp/login');
        } else {
            $this->load->view('admin/dashboard');
        }
    }

 

    function login() {
        if ($this->session->userdata('admin_id') == null) {
            if (isset($_REQUEST['loginBtt'])) {
                $username = $this->input->post('email', true);
                $password = $this->input->post('password', true);
                $this->load->model('user_model');
                $data = array(
                    'user'=>$username,
                    'password'=>$password,
                );
                $result = $this->user_model->authen($data); 
                if ($result == 0) {
                    redirect('admincp/login/error');
                } else {
                    $session_user = array(
                        'admin_id' =>$result,
                        'admin_name' => $username, 
                    );
                    $this->session->set_userdata($session_user);
                    redirect('admincp/index');
                }
            } 
            $this->load->view('admin/login');
        } else {
            redirect('admincp/index');
        }
    }

}
