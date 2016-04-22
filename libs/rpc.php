<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

class Rpc extends CI_Controller {

	private $data = [
		'user' => 'dudan',
		'password' => 'Dev@2015',
		'blogid' => 1,
	];

	private $xmlrpc;

	public function __construct()
	{
        parent:: __construct();
        date_default_timezone_set('America/Los_Angeles');
        include(APPPATH.'libraries/IXR_Library.php');
        $this->xmlrpc = new IXR_CLIENT('http://dudan.dev/wordpress/xmlrpc.php');

        // Create default image thumbnail
        if ( ! file_exists(FCPATH.'images/default.txt')) {
        	$image = $this->image('default-image-thumbnail.png', 'image/png', FCPATH.'images/default.png');

        	file_put_contents(FCPATH.'images/default.txt', json_encode($image));
        }
    }

    private function save_image($image_url, $image_name)
    {
    	if ( ! $image_url) {
    		return 0;
    	}

    	// Get image info
    	$image = getimagesize($image_url);
    	switch($image["mime"]){
	        case "image/jpeg":
	            $image_path = FCPATH.'images/'.$image_name.'.jpg';
	            $image_name .= '.jpg';
	        	break;
	        case "image/gif":
	            $image_path = FCPATH.'images/'.$image_name.'.gif';
	            $image_name .= '.gif';
	      		break;
	      	case "image/png":
	          	$image_path = FCPATH.'images/'.$image_name.'.png';
	          	$image_name .= '.png';
	      		break;
	    	default:
	        	$image_path = false;
	    		break;
	    }
    	// Image save
    	$ch = curl_init($image_url);
		$fp = fopen($image_path, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);

		return [
			'image_path' => $image_path,
			'image_name' => $image_name,
			'image_type' => $image["mime"],
		];
    }

    public function image($image_name, $image_type, $image_path)
    {
    	// wp.uploadFile
    	$result = $this->xmlrpc->query(
    		"wp.uploadFile",
	    	$this->data['blogid'],
	    	$this->data['user'],
	    	$this->data['password'],
			[
    			'name' => $image_name,
    			'type' => $image_type,
    			'bits' => new IXR_Base64(file_get_contents($image_path)),
    			'overwrite' => false
    		]
	    );

	    if ( ! $result)
	    {
	        // die('Upload Image An error occurred - '.$this->xmlrpc->getErrorCode().":".$this->xmlrpc->getErrorMessage());
	        return 0;
	    }
	    else
	    {
	    	return $this->xmlrpc->getResponse();
	    }
    }

    private function create_category($new_category)
    {
    	// $new_category = [
    	// 	'name' => 'BuddyPress WordPress Theme',
    	// 	'taxonomy' => 'category',
    	// 	'parent' => 2
    	// ];
    	// wp.getTerms
    	$result = $this->xmlrpc->query(
    		"wp.getTerms",
	    	$this->data['blogid'],
	    	$this->data['user'],
	    	$this->data['password'],
	    	'category'
	    );

	    if ( ! $result)
	    {
	        die('Get category An error occurred - '.$this->xmlrpc->getErrorCode().":".$this->xmlrpc->getErrorMessage());
	    }
	    else
	    {
	    	$categories = $this->xmlrpc->getResponse();
	    	foreach ($categories as $category) {
	    		if ($category['name'] == $new_category['name'] && $category['parent'] == $new_category['parent']) {
	    			return $category['term_id'];
	    		}
	    	}

	    	// new Terms
	    	$result = $this->xmlrpc->query(
	    		"wp.newTerm",
		    	$this->data['blogid'],
		    	$this->data['user'],
		    	$this->data['password'],
		    	$new_category
		    );

	    	return $this->xmlrpc->getResponse();
	    	if ( ! $result)
		    {
		        die('Create category An error occurred '.$name.' - '.$this->xmlrpc->getErrorCode().":".$this->xmlrpc->getErrorMessage());
		    }
		    else
		    {
		    	return $this->xmlrpc->getResponse();
		    }
	    }
    }

    public function post()
    {
    	$this->load->database();

		$this->db->where('status', 'pending');
		$this->db->from('articles');
		$query = $this->db->get();
		$article = $query->first_row();

		if (empty($article)) {
			die('Finish!');
		}

        echo "Start with: ".$article->title." ==> ";

		// Get post from url
		$this->load->library("simple_html_dom");
		$html = @file_get_html($article->url);
		$html = $html->find('article[class="post"]', 0);

		// categories
        $html_categories = $html->find('header', 0)->find('div[class="meta-info"]', 0)->find('ul[class="td-category"]', 0)->find('li');
        $categories = [];
        foreach ($html_categories as $category) {
            $temp_link = $category->find('a', 0)->href;
            $temp_name = $category->find('a', 0)->innertext;
            $categories[] = [
                'name' => $temp_name,
                'link' => $temp_link,
                'parent' => 0
            ];
            unset($temp_link);
            unset($temp_name);
        }

        $count = count($categories);
        for ($i=0; $i<$count-1; $i++) {
            for ($j=$i+1; $j<$count; $j++) {
                if (strpos($categories[$i]['link'], $categories[$j]['link']) !== false) {
                    $categories[$j]['child'][] = $i;
                }

                if (strpos($categories[$j]['link'], $categories[$i]['link']) !== false) {
                    $categories[$i]['child'][] = $j;
                }
            }
        }

        foreach ($categories as $cate_id => $category) {
        	$categories[$cate_id]['id'] = $this->create_category([
        		'name' => $category['name'],
        		'parent' => $categories[$cate_id]['parent'],
        		'taxonomy' => 'category'
        	]);

        	if (isset($category['child'])) {
        		foreach ($category['child'] as $child_category_id) {
        			$categories[$child_category_id]['parent'] = $categories[$cate_id]['id'];
        		}
        	}
        }

        foreach ($categories as $category) {
        	$post['categories'][] = $category['name'];
        }

        // tags
        $tags = $html->find('footer', 0)->find('ul[class="td-tags"]', 0);

        if ($tags != null) {
        	$tags = $tags->find('li');
        	foreach ($tags as $tag) {
	        	if ($tag->find('a', 0) != null) {
	        		$post['tags'][] = $tag->find('a', 0)->innertext;
	        	}
	        }
        }
        else {
        	$post['tags'] = [];
        }

        // Save image, import to Wordpress
        $image = $html->find('div[class="thumb-wrap"]', 0);
        if ($image != null) {
            $image_url = $image->find('img[class="entry-thumb"]', 0)->src;
        }
        else {
            $image_url = null;
        }
		$image = pathinfo($article->image);
		$image = $this->save_image($article->image, strtolower($image['filename']));

		if ( ! $image) {
			$blog_image = json_decode(file_get_contents(FCPATH.'images/default.txt'), TRUE);
		}
		else {
			$blog_image = $this->image($image['image_name'], $image['image_type'], $image['image_path']);
			unlink($image['image_path']);
		}

		if ( ! $blog_image) {
			$this->db->where('id', $article->id);
			$this->db->update('articles', ['status' => 'failed']);

	    	$this->load->helper('url');
			echo '<meta http-equiv="refresh" content="5;URL='.site_url('rpc/post').'">';
			die();
		}

        // content
        $html->find('header', 0)->outertext = '';
        $html->find('div[class="thumb-wrap"]', 0)->outertext = '';
        $html->find('div[class="td-a-rec-id-content_inlineleft"]', 0)->outertext = '';
        $html->find('div[class="td-a-rec-id-content_bottom"]', 0)->outertext = '';
        $html->find('div[class="clearfix"]', 0)->outertext;
        $html->find('footer', 0)->outertext = '';

        foreach ($html->find('a') as $link) {
        	// if (strpos($link->href, 'http://theme123.net/') !== false) {
        	// 	$link->outertext = $link->innertext;
        	// }
        	$link->outertext = $link->innertext;
        }

        $post['content'] = trim($html->innertext);

		// new Post
		$result = $this->xmlrpc->query(
    		"metaWeblog.newPost",
	    	$this->data['blogid'],
	    	$this->data['user'],
	    	$this->data['password'],
	    	[
	    		'title' => $article->title,
				'description' => $post['content'],
				'post_type' => "post",
				'dateCreated' => new IXR_Date(strtotime($article->publish_time)),
				'categories' => $post['categories'],
				'mt_keywords' => $post['tags'],
				'mt_excerpt' => trim($article->description),
// string mt_text_more: Post "Read more" text.
// string mt_allow_comments: "open" or "closed"
// string mt_allow_pings: "open" or "closed"
// string wp_slug†
// string wp_password†
// string wp_author_id†
				'wp_author_display_name' => 'masterchef',
				'post_status' => 'pending',//'publish',
				'wp_post_format' => 'standard',
// bool sticky† (Added in WordPress 2.7.1)
				//'custom_fields' => [],
				'wp_post_thumbnail' => $blog_image['id']
	    	],
	    	TRUE
	    );

	    if ( ! $result)
	    {
	        die('Create post An error occurred - '.$this->xmlrpc->getErrorCode().":".$this->xmlrpc->getErrorMessage());

            echo 'Fail!';
	    }
	    else
	    {
	    	$post_id = $this->xmlrpc->getResponse();

	    	$this->db->where('id', $article->id);
			$this->db->update('articles', ['status' => 'imported']);

            echo 'Done!';

	    	$this->load->helper('url');
			echo '<meta http-equiv="refresh" content="5;URL='.site_url('rpc/post').'">';
	    }
    }
}
