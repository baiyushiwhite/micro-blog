<?php
class Tag extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->model('momo/user_model');
		$this->load->model('momo/follows_model');
		$this->load->model('momo/tag_user_model');
		$this->load->model('momo/tag_blog_model');
		$this->load->model('momo/hot_tag_model');
		$this->load->model('momo/blog_model');
		$this->load->library('session');
		$this->load->helper('url');
	}
	
	/**
	 * 跳转到发现页面
	 * 获得热门tag列表，根据订阅的人最多的
	 */
	public function explore()
	{
		$current_user_id = $this->session->userdata('user_id');
		$current_user = $this->user_model->get_user_by_id($current_user_id);
		$hot_tags = $this->hot_tag_model->get_hot_tags();
		$hot_tag_blog_list = $this->blog_model->get_hot_tag_blogs();
		$my_tag_list = $this->tag_user_model->get_tag_list($current_user_id);
		$data['hot_tag_list'] = $hot_tags;
		$data['hot_tag_blog_list'] = $hot_tag_blog_list;
		$data['my_tag_list'] = $my_tag_list;
		$data['current_user'] = $current_user;
		$this->load->view('templates/header');
		$this->load->view('templates/blogtemplate');
		$this->load->view('mainpages/explore', $data);
		$this->load->view('templates/footer') ;
	}
	
	/**
	 * 通过传入的tag，返回tag中包含该tag的blog列表，按照时间先后顺序排列
	 * @param unknown_type $tag
	 */
	public function search()
	{
		//获得当前用户账号
		$current_user_id = $this->session->userdata('user_id');
		if($current_user_id==null||$current_user_id==''){
			//用户没有登陆
			redirect('momo/user/loginpage');
		}else{
			$current_user = $this->user_model->get_user_by_id($current_user_id);
			$tag = $this->input->get('tag');
			
			$this->hot_tag_model->add_hot_tag($tag);
			
		    $blog_list = $this->tag_blog_model->get_blogs_by_tag($tag);
		    
			//获得我关注的博客个数
			$ifollow_count = $this->follows_model->get_ifollow_count($current_user_id);
			//获得我订阅的tag列表和搜索的tag的并集
			$my_tag_list = $this->tag_user_model->get_tag_list($current_user_id);
		    $in_my_tag = $this->tag_user_model->in_my_tag($tag, $current_user_id);
		    
		    $data['current_user_id'] = $current_user_id;
			$data['blog_list'] = $blog_list;
			$data['ifollow_count'] = $ifollow_count;
			$data['my_tag_list'] = $my_tag_list;
		    $data['current_tag'] = $tag;
		    $data['in_my_tag'] = $in_my_tag;
		    
			$this->load->view('templates/header');
		    $this->load->view('templates/blogtemplate');
		    $this->load->view('mainpages/tag', $data);
		    $this->load->view('templates/footer') ;
		}
	}
	
	/**
	 * 新建用户订阅
	 */
	public function create_subscribe()
	{
		$tag = $this->input->get('tag');
		$user_id = $this->input->get('user_id');
		$this->tag_user_model->insert_tag_user($tag, $user_id);
		echo "cancle subscribe";
	}
	
	/**
	 * 取消订阅
	 */
	public function cancle_subscibe()
	{
		$tag = $this->input->get('tag');
		$user_id = $this->input->get('user_id');
		$this->tag_user_model->delete_tag_user($tag, $user_id);
		echo "subscribe";
	}
}