<?php
/**
 *
 * @author baiyushi
 *
 */
class Blog extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('momo/user_model');
		$this->load->model('momo/blog_model');
		$this->load->model('momo/tag_user_model');
		$this->load->model('momo/tag_blog_model');
		$this->load->model('momo/follows_model');
		$this->load->model('momo/reply_model');
		$this->load->model('momo/love_model');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}
	
	/**
	 * 跳转到首页
	 *
	 */
	public function home()
	{
		//获得当前用户账号
		$current_user_id = $this->session->userdata('user_id');
		if($current_user_id==null||$current_user_id==''){
			//用户没有登陆
			redirect('momo/user/loginpage');
		}else{
			$current_user = $this->user_model->get_user_by_id($current_user_id);
			//获得新鲜事列表
			$my_fresh_blogs_list = $this->blog_model->get_fresh_blog_list($current_user_id);
			//获得我关注的博客列表
			$ifowllow_count = $this->follows_model->get_ifollow_count($current_user_id);
			$ifollow_list = $this->follows_model->get_ifollow($current_user_id);
		
			//获得我订阅的tag列表
			$my_tag_list = $this->tag_user_model->get_tag_list($current_user_id);
			$mytag_count = $this->tag_user_model->get_tag_count($current_user_id);
			$data['current_user'] = $current_user;
			$data['blog_list'] = $my_fresh_blogs_list;
			$data['ifollow_count'] = $ifowllow_count;
			$data['my_tag_list'] = $my_tag_list;
			$data['ifollow_list'] = $ifollow_list;
			$data['mytag_count'] = $mytag_count;
			$this->load->view('templates/header');
			$this->load->view('mainpages/index', $data);
			$this->load->view('templates/footer');
		}
	}
	
	/**
	 * 跳转到发布文字博客页面
	 */
	public function new_article_blog()
	{
		$data['title'] = "";
		$data['content'] = "";
		$data['edit_tags'] = "";
		
		$this->load->view('templates/rich_text_editor_header');
		$this->load->view('templates/blogtemplate');
		$this->load->view('mainpages/new_article_blog');
		$this->load->view('templates/footer');
	}
	
	/**
	 * 发布文字博客
	 */
	public function publish_article_blog()
	{
		$current_user_id = $this->session->userdata('user_id');
		if($current_user_id==null||$current_user_id==''){
			//用户没有登陆
			redirect('momo/user/loginpage');
		}
		$content = $this->input->post("content");
		$title = $this->input->post("title");
		$tags = $this->input->post("edit_tags");
		
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		$this->form_validation->set_rules('edit_tags', 'edit_tags', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = $title;
			$data['content'] = $content;
			$data['edit_tags'] = $tags;
			
			$this->load->view('templates/rich_text_editor_header');
			$this->load->view('templates/blogtemplate');
			$this->load->view('mainpages/new_article_blog');
			$this->load->view('templates/footer');
		
		}
		else
		{
			$new_tags = trim($tags);
			
			$blog_name = $this->user_model->get_user_by_id($current_user_id)->blog_name;
		    $blog_id = $this->blog_model->insert_blog($blog_name, $title, $content, $new_tags);
		    $tag_list = explode("\r", $new_tags);
		    foreach ($tag_list as $tag){
		    	if($tag!='\r'&&$tag!=''){
		    		$this->tag_blog_model->insert_tag_blog($blog_id, trim($tag));
		    	}
		    }
		    redirect('momo/blog/home');
		}
	}
	
	/**
	 * 查看某篇博文
	 * @param unknown_type $blog_id
	 */
	public function show($blog_id){
		$blog = $this->blog_model->get_blog($blog_id);
		$data['blog'] = $blog;
		$this->load->view('templates/header');
		$this->load->view('templates/blogtemplate');
		$this->load->view('mainpages/show',$data);
		$this->load->view('templates/footer');
	}
	
	/**
	 * 查看某个user_id博客的个人主页
	 * @param unknown_type $user_id
	 */
	public function personal($user_id)
	{
		$user = $this->user_model->get_user_by_id($user_id);
		$blog_list = $this->blog_model->get_blogs_by_user($user_id);
		$to_follow = $this->follows_model->get_follow($this->session->userdata('user_id'), $user_id);
		$data['user'] = $user;
		$data['blog_list'] = $blog_list;
		$data['to_follow'] = $to_follow;
		$this->load->view('templates/header');
		$this->load->view('templates/blogtemplate', $data);
		$this->load->view('mainpages/personal', $data);
		$this->load->view('templates/footer');
	}
	
	/**
	 * 新建评论
	 */
	public function add_reply()
	{
		$blog_id = $this->input->get('blog_id');
		$to_id = $this->input->get('to');
		if($to_id==null||$to_id==""){
			$to_id = $this->blog_model->get_blog($blog_id)->user_id;
			$to_blog_name = "the blog";
		}else{
			$to_blog_name = $this->user_model->get_user_by_id($to_id)->blog_name;
		}
		$from_id = $this->input->get('from');
		$from_blog_name = $this->user_model->get_user_by_id($from_id)->blog_name;
		$content = $this->input->get('content');
		$result = $this->reply_model->insert_reply($blog_id, $to_id, $from_id, $from_blog_name, $to_blog_name, $content);
		if($result=="OK"){
			//评论成功，该博客的heat加一
			$this->blog_model->add_reply($blog_id);
			$from_blog_url = base_url('index.php/momo/blog/personal/'.$from_id);
			$to_blog_url = base_url('index.php/momo/blog/personal/'.$to_id);
			$result = "<p><span><a class='a6' href='$from_blog_url'>".$from_blog_name."</a> reply <a class='a6' href='$to_blog_url'>".$to_blog_name."</a>:".$content."</span></p>";
		}
		echo $result;
	}
	
	/**
	 * 获得该博客的所有评论
	 */
	public function get_all_reply()
	{
		$blog_id = $this->input->get('blog_id');
		$reply_list = $this->reply_model->get_reply_by_blog_id($blog_id);
		$send_str = "";
		$send_str = '<?xml version="1.0" encoding="UTF-8"?><reply_list>';
		if($reply_list!=null){
			foreach ($reply_list as $reply){
				$from_blog_url = base_url('index.php/momo/blog/personal/'.$reply->from_id);
				$to_blog_url = base_url('index.php/momo/blog/personal/'.$reply->to_id);
				$send_str = $send_str."<reply><from_name>".$reply->from_blog_name."</from_name>";
				$send_str = $send_str."<to_name>".$reply->to_blog_name."</to_name>";
				$send_str = $send_str."<content>".$reply->content . "</content>";
				$send_str = $send_str."<from_blog_url>".$from_blog_url."</from_blog_url>";
				$send_str = $send_str."<to_blog_url>".$to_blog_url."</to_blog_url></reply>";
			}
			$send_str = $send_str."</reply_list>";
		}else{
			$send_str = "";
		}
		
		echo $send_str;
	}
	
	/**
	 * 确认转载后跳转页面
	 * @param unknown_type $blog_id
	 */
	public function convey_confirm($blog_id)
	{
		$current_user_id = $this->session->userdata('user_id');
		if($current_user_id==null||$current_user_id==''){
			//用户没有登陆
			redirect('momo/user/loginpage');
		}
		$content = $this->input->post("content");
		$title = $this->input->post("title");
		$tags = $this->input->post("edit_tags");
		$source_id = $this->input->post("source_id");
		$source_name = $this->input->post("source_name");
		$source_blog_id = $this->input->post("source_blog_id");
		$convey_reason = $this->input->post("convey_reason");
		
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		$this->form_validation->set_rules('edit_tags', 'edit_tags', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = $title;
			$data['content'] = $content;
			$data['edit_tags'] = $tags;
			$data['convey_reason']	= $convey_reason;
			
			$this->load->view('templates/rich_text_editor_header');
			$this->load->view('templates/blogtemplate');
			$this->load->view('mainpages/convey', $data);
			$this->load->view('templates/footer');
		
		}
		else
		{
			$new_tags = trim($tags);
			$blog_name = $this->user_model->get_user_by_id($current_user_id)->blog_name;
			$blog_id = $this->blog_model->convey_blog($source_id, $source_name, $blog_name, $title, $content, $tags, $source_blog_id, $convey_reason);
		    $tag_list = explode("\r", $new_tags);
			foreach ($tag_list as $tag){
				if($tag!='\r'&&$tag!=''){
					$this->tag_blog_model->insert_tag_blog($blog_id, trim($tag));
				}
			}
			redirect('momo/blog/home');
		}
		
// 		$current_user_id = $this->session->userdata('user_id');
// 		if($current_user_id==null||$current_user_id==''){
// 			//用户没有登陆
// 			redirect('momo/user/loginpage');
// 		}
// 		$content = $this->input->post("content");
// 		$title = $this->input->post("title");
// 		$source_id = $this->input->post("source_id");
// 		$source_name = $this->input->post("source_name");
// 		$source_blog_id = $this->input->post("source_blog_id");
// 		$convey_reason = $this->input->post("convey_reason");
		
// 		$tags = $this->input->post("edit_tags");
// 		$blog_name = $this->user_model->get_user_by_id($current_user_id)->blog_name;
// 		$blog_id = $this->blog_model->convey_blog($source_id, $source_name, $blog_name, $title, $content, $tags, $source_blog_id, $convey_reason);
// 		$this->blog_model->add_convey($blog_id);
// 		$tag_list = explode("\n", $tags);
// 		foreach ($tag_list as $tag){
// 			$this->tag_blog_model->insert_tag_blog($blog_id, $tag);
// 		}
// 		redirect('momo/blog/home');
	}
	
	/**
	 * 跳转到转载页面
	 * @param unknown_type $blog_id
	 */
	public function convey($blog_id){
		$current_user_id = $this->session->userdata('user_id');
		$current_user_name = $this->user_model->get_user_by_id($current_user_id)->blog_name;
		$blog = $this->blog_model->get_blog($blog_id);
		$content = $blog->content;
		$title = $blog->title;
		$source_id = $blog->user_id;
		$source_name = $blog->blog_name;
		
		$data['title'] = $title;
		$data['content'] = $content;
		$data['source_id'] = $source_id;
		$data['source_name'] = $source_name;
		$data['source_blog_id'] = $blog_id;
		
		$this->load->view('templates/rich_text_editor_header');
		$this->load->view('templates/blogtemplate');
		$this->load->view('mainpages/convey', $data);
		$this->load->view('templates/footer');
	}
	
	/**
	 * 新建喜欢关系
	 */
	public function love_blog()
	{
		$blog_id = $this->input->get('blog_id');
		$user_id = $this->session->userdata('user_id');
		$user = $this->user_model->get_user_by_id($user_id);
        $user_name = $user->blog_name;
        
        $addheat = $this->love_model->exist_love($blog_id, $user_id);
        $love_list = $this->love_model->insert_love($blog_id, $user_id, $user_name);
		
		$this->blog_model->add_love($blog_id);
		
		$send_str = "";
		$send_str = '<?xml version="1.0" encoding="UTF-8"?><reply_list>';
		if($love_list!=null){
			foreach ($love_list as $love){
				$user_url = base_url('index.php/momo/blog/personal/'.$love->user_id);
				$send_str = $send_str."<love><user_name>".$love->user_name."</user_name>";
				$send_str = $send_str."<user_url>".$user_url."</user_url></love>";
			}
			
			$send_str = $send_str."<addheat>".$addheat."</addheat></love_list>";
		}else{
			$send_str = "";
		}
		echo $send_str;
	}
}
