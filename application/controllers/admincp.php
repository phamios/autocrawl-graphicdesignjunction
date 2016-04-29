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

    public function details() {
        $this->load->view('home/index');
    }

    function login() {
        if ($this->session->userdata('admin_id') == null) {
            if (isset($_REQUEST['go'])) {
                $username = $this->input->post('email', true);
                $password = $this->input->post('password', true);
                $this->load->model('user_model');
                $result = $this->user_model->authen($username, $password);
                if (empty($result)) {
                    redirect('admincp/login/error');
                } else {
                    $session_user = array(
                        'admin_id' => $result['user_id'],
                        'admin_name' => $result['user_name'],
                        'admin_type' => $result['user_type'],
                        'admin_active' => $result['user_active'],
                    );
                    $this->session->set_userdata($session_user);
                    redirect('admincp/index');
                }
            }
            $this->lang->load("login", "vietnam");
            $this->load->view('backend/login');
        } else {
            redirect('admincp/index');
        }
    }

}
