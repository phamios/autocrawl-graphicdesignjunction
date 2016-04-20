<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index($cate = 0) {
        $this->load->helper(array('javelin'));
        // $page = $page + 1;
        // $this->run_process($page);
        //$this->get_category();
        // for($i = 1; $i < 3; $i++){ 
        // 	$this->run_process($i);
        // } 

        $this->load->model('cate_model');
        $category = $this->cate_model->list_all();
        foreach ($category as $cate) {
            echo $cate->id . '-' . $cate->status;
            echo "=============";
            if ($cate->status == 0) {

                $this->run_process($cate->id, 1);
            }
        }
        //echo '<meta http-equiv="Refresh" content="1; url=http://localhost/~sonpham/autocrawl/index.php/welcome/index/'.$page.'">';
        //  $this->load->view('welcome_message');
    }

    /**
     * Run Main Process
     * @param type $cateid
     * @param type $page
     */
    function run_process($cateid = 0, $page = 1) {

        $this->load->helper('url');
        $this->load->helper(array('simple_html_dom'));
        $this->load->model('cate_model');
        $this->load->model('content_model');
        $this->load->helper('slug');
        $link = $this->cate_model->get_url($cateid);


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $link . 'page/' . $page);
        curl_setopt($curl, CURLOPT_REFERER, $link . 'page/' . $page);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $str = curl_exec($curl);
        curl_close($curl);

        $html = str_get_html($str);

        $post_title = null;
        $post_cateid = $cateid;
        $post_img_thumb = null;
        $post_img = null;
        $post_des = null;
        $post_content = null; 
        
        if (empty($html->find('div.oneblog')) !== true) {
            foreach ($html->find('div.oneblog') as $e) {
                $content = str_get_html($e->innertext);

                // get Title 
                foreach ($content->find('div.oneblog_titlearea') as $title) {
                    $url_link = str_get_html($title);
                    foreach ($url_link->find('a') as $url) {
                        //    echo "<b>url:</b> " . $url->href . "<br>";
                        //Get details content and insert it now
                        $post_content = $this->get_content_details($url->href);
                    }
                    echo "<b>title:</b> " . $title->plaintext . "<br>";
                    $post_title = $title->plaintext;
                }

                // Get Image thumb
                foreach ($content->find('img') as $image) {
                    // echo "<b>img:</b> " . $image->src . '<br>';
                    $post_img_thumb = $image->src;
                    $post_img = str_replace("_thumbnail", "", $image->src);
                }

                //Get description 
                foreach ($content->find('div.excerpt') as $desp) {
                    //  echo "<b>Des:</b>" . str_replace("Continue Reading", "", $content->plaintext) . '<br/>';
                    $post_des = str_replace("Continue Reading", "", $content->plaintext);
                }

                echo "==================" . $page . "======================<br>";
                $data = array(
                    'slug' => create_slug($post_title),
                    'title' => $post_title,
                    'cateid' => $post_cateid,
                    'image_thumb' => $post_img_thumb,
                    'image_link' => $post_img,
                    'des' => $post_des,
                    'content' => $post_content,
                    'status' => 1,
                );
                $result = $this->content_model->insert($data);
            }
            $new_page = $page + 1;
            echo '<meta http-equiv="refresh" content="2;URL=' . site_url('welcome/run_process/' . $cateid . '/' . $new_page) . '">';
        } else {
            //$this->get_category();
            $this->cate_model->update_status($cateid);
            echo '<meta http-equiv="refresh" content="2;URL=' . site_url('welcome/index') . '">';
        }
        //$next_page = $page + 1; 
        //redirect("Welcome/index/".$next_page); 
        //$this->load->view('welcome_message');
    }

    /**
     * Get All Category 
     */
    function get_category() {
        $this->load->helper(array('simple_html_dom'));

        $html = file_get_html('http://graphicdesignjunction.com');
        $this->load->helper('url');
        $this->load->helper('javelin');

        foreach ($html->find('div#navbar') as $e) {
            $url_link = str_get_html($e);
            foreach ($url_link->find('a') as $url) {
                echo "<b>url:</b> " . $url->href . "<br>";
                echo "<b>text:</b> " . $url->plaintext . "<br>";
                $this->load->model('cate_model');
                $id = $this->cate_model->insert(array(
                    'title' => $url->plaintext,
                    'root' => $url->href,
                    'catelink' => trim(site_url($url->plaintext)),
                    'slug' => gen_slug($url->plaintext),
                ));
            }
        }
        die;
    }

    /**
     * Get Content Details
     * @param type $url
     * @return type
     */
    function get_content_details($url = null) {
        $this->load->helper(array('simple_html_dom'));

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_REFERER, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $str = curl_exec($curl);
        curl_close($curl);
 
        $html = str_get_html($str);
        $content_main = null;
        foreach ($html->find('div.the_content') as $content) {
            //  echo "<b>Content: </b>" . $content->plaintext;
            $content_main = $content->plaintext;
        }
        return $content_main;
    }

    /**
     * RegularExpression
     * @param type $main_text
     * @param type $change_text
     * @param type $format
     * @return type
     */
    function regular_express($main_text, $change_text, $format) {
        return $content;
    }

}
