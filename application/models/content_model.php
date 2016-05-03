<?php

date_default_timezone_set('America/Los_Angeles');
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function load_lastest_post() {
        $this->db->limit(5);
        $this->db->order_by('id', "desc");
        $query = $this->db->get('content');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    public function load_newpost_slide() {
        $this->db->limit(3);
        $this->db->order_by('id', "desc");
        $query = $this->db->get('content');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    public function load_news_post_slide() {
        $this->db->limit(5);
        $this->db->order_by('id', "desc");
        $query = $this->db->get('content');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
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
                'des' => $data['des'],
                'content' => $data['content'],
                'status' => $data['status'],
                'slug' => $data['slug'],
                'create_date' => date('Y-m-d'),
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
