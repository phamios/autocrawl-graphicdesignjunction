<?php

date_default_timezone_set('America/Los_Angeles');
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function list_all() { 
        $this->db->order_by('id', "asc");
        $query = $this->db->get('admin');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    
    public function authen($array = null){
        $this->db->where(array(
            'username'=>$array['user'],
            'password'=>$array['password']
        ));
        
        $query = $this->db->get('admin');
        if($query->num_rows() > 0){
            foreach($query->result() as $result){
                 if($this->check_active($result->id) > 0){
                     return $result->id;
                 }else{
                     return 0;
                 }
            }
        } else {
            return 0;
        }
    }
    
    public function check_active($userid = null){
        $this->db->where('id',$userid);
        $query = $this->db->get('admin');
        if($query->num_rows() > 0){
            foreach($query->result() as $result){
                return $result->active;
            }
        } else {
            return 0;
        }
    }

}
