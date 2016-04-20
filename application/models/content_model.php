<?php
date_default_timezone_set('America/Los_Angeles');
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert($data) {
        $id = 0;
        $query = $this->db->get_where('content', array('slug' => $data['slug']));
        $result = $query->result();
        if (empty($result)) {
            $this->db->insert('content', array(
                'cateid' => strtolower($data['cateid']),
                'title' => $data['title'],
                'image_thumb' => $data['image_thumb'],
                'image_link' => strtolower($data['image_link']),
                'des'=>$data['des'],
                'content'=>$data['content'],
                'status'=>$data['status'],
                'slug'=>$data['slug'],
                'create_date'=>date('Y-m-d'), 
                'active' => 1,
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
