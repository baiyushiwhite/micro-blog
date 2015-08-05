<?php
class User_model extends CI_Model{
	var $user_id, $blog_name, $password, $description;
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * insert a new user by the params
	 * 
	 * @param unknown_type $user_id
	 * @param unknown_type $blog_name
	 * @param unknown_type $password
	 * @param unknown_type $description
	 */
	public function insert_user($user_id, $blog_name, $password, $description)
	{
		$this->user_id = $user_id;
		$this->blog_name = $blog_name;
		$this->password = $password;
		$this->description = $description;
		
		$this->db->insert('user', $this);
	}
	
	/**
	 * 登陆验证
	 * @param unknown_type $user_id
	 * @param unknown_type $password
	 * @return string
	 */
	public function verify_user($user_id, $password)
	{
		$query = $this->db->get_where('user', array('user_id'=>$user_id));
		$user = $query->row();
		if($user==null){
			return null;
		}else if($user->password==$password){
			return $user;
		}else{
			return null;
		}
	}
	
	/**
	 * 注册用户名验证
	 * @param unknown_type $user_id
	 * @return string
	 */
	public function search_user($user_id)
	{
		$query = $this->db->get_where('user', array('user_id'=>$user_id));
		$num = $query->num_rows();
		if($num<=0){
			return "用户名可用";
		}else {
			return "该用户名已被占用";
		}
	}
	
	/**
	 * 根据传入的user_id返回一个user对象
	 * @param unknown_type $user_id
	 */
	public function get_user_by_id($user_id){
		$query = $this->db->get_where('user', array('user_id'=>$user_id));
		$num = $query->num_rows();
		if($num > 0){
			return $query->row();
		}
	}
	
	
	
}
