<?php
/**
 * 
 * @author baiyushi
 *
 */
class User extends CI_Controller{
	 
	function __construct()
	{
		parent::__construct();
		$this->load->model('momo/user_model');
		$this->load->model('momo/follows_model');
		$this->load->library('session');
		$this->load->helper('url');
	}
	
	
	/**
	 * 跳转到登陆页面
	 */
	public function loginpage()
	{
		$this->load->view('templates/loginHeader');
		$this->load->view('user/login',array('remindInfo'=>''));
		$this->load->view('templates/footer');
	}
	
	/**
	 * 注册
	 */
	public function register()
	{
		$user_id = $this->input->post('user_id');
		$blog_name = $this->input->post('blog_name');
		$password = $this->input->post('password');
		$description = $this->input->post('description');
		$this->user_model->insert_user($user_id, $blog_name, $password, $description);
		$this->load->view('templates/loginHeader');
		$this->load->view('user/login',array('remindInfo'=>''));
		$this->load->view('templates/footer');
	}
	
	/**
	 * 登陆验证
	 */
	public function login()
	{
		$user_id = $this->input->post('user_id');
		$password = $this->input->post('password');
		$user = $this->user_model->verify_user($user_id, $password);
		
		if($user!=null){
			$newdata = array(
			           'user_id' => $user_id,
					   'blog_name' => $user->blog_name
					);
			$this->session->set_userdata($newdata);
			redirect('momo/blog/home');
		}else{
			$this->load->view('templates/loginheader');
			$this->load->view('user/login',array('remindInfo'=>'用户名或密码错误'));
			$this->load->view('templates/footer');
		}
	}
	
	/**
	 * 检查用户账号是否已存在
	 */
	public function check_user_id()
	{
		$user_id = $this->input->get('user_id');
		$search_result = $this->user_model->search_user($user_id); 
		echo $search_result;
	}
	
	/**
	 * 注销登录
	 */
	public function user_exit()
	{
		$newdata = array(
				'user_id' => ''
		);
		$this->session->set_userdata($newdata);
		redirect('momo/user/loginpage');
	}
	
	/**
	 * 创建关注关系
	 * @param unknown_type $follower
	 * @param unknown_type $followee
	 */
	public function create_follow_relation()
	{
		$follower = $this->input->get('follower');
		$followee = $this->input->get('followee');
		$follower_blog_name = $this->user_model->get_user_by_id($follower)->blog_name;
		$followee_blog_name = $this->user_model->get_user_by_id($followee)->blog_name;
		$result = $this->follows_model->insert_follow($follower, $followee, $follower_blog_name, $followee_blog_name);
		echo $result;
	}
	
	/**
	 * 取消关注
	 */
	public function cancle_follow_relation()
	{
		$follower = $this->input->get('follower');
		$followee = $this->input->get('followee');
		$result = $this->follows_model->delete_follow($follower, $followee);
		echo $result;
	}
	
	/**
	 * 获得当前用户关注的所有博客
	 */
	public function following()
	{
		$current_user_id = $this->session->userdata['user_id'];
		$ifollow_list = $this->follows_model->get_ifollow($current_user_id);
		$data['ifollow_list'] = $ifollow_list;
		$this->load->view('templates/header');
		$this->load->view('templates/blogtemplate');
		$this->load->view('mainpages/following', $data);
		$this->load->view('templates/footer');
	}
}