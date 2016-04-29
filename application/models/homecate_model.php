<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cate_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function list_home_cate(){
        $this->db->order_by('position', "asc");
        $query = $this->db->get('home_cate');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    
    public function update_position($cateid=null,$position=null){
        $data = array('position'=>$position);
        $this->db->where('cateid',$cateid);
        $this->db->update('home_cate',$data);
    }
     
    public function update_status($cateid) {
        $data = array(
            'status' => 1,
        );
        $this->db->where('id', $cateid);
        $this->db->update('home_cate', $data);
    }
    
    /**
     * Insert Home Cate
     * @param type $data
     * @return type
     */
    public function inset_home_cate($data=null){
        $id = 0;
        $query = $this->db->get_where('home_cate', array('slug' => $data['slug']));
        $result = $query->result();
        if (empty($result)) {
            $this->db->insert('category', array(
                'cateid' => $data['cateid'],
                'cate_name' => $data['catename'],
                'position' => $data['position'],
                'slug' => strtolower($data['slug']), 
                'active' => 1,
                'cate_image'=>$data['image']
            ));
            $id = $this->db->insert_id();
            $this->db->trans_complete();
        } else {
            foreach ($query->result() as $row) {
                $id = $row->id;
            }
        }
        return $id;
    }

    
}