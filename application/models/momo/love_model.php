<?php
class Love_model extends CI_Model{
	var $blog_id, $user_id, $user_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 建立该用户和该博客的喜欢关系
	 * @param unknown_type $blog_id
	 * @param unknown_type $user_id
	 * @param unknown_type $user_name改用户 的博客名
	 */
	public function insert_love($blog_id, $user_id, $user_name)
	{
		$query = $this->db->get_where('love', array('blog_id'=>$blog_id, 'user_id'=>$user_id));
		if($query->num_rows()==0){
			$this->blog_id = $blog_id;
			$this->user_id = $user_id;
			$this->user_name = $user_name;
			$this->db->insert('love', $this);
		}
		$this->db->select('*');
		$this->db->from('love');
		$this->db->where('blog_id',$blog_id);
		$query = $this->db->get();
		$result = null;
		if($query->num_rows()>0){
			$result =  $query->result();
		}
		return $result;
	}
	
	/**
	 * 判断该用户是否已经喜欢该博客
	 * @param unknown_type $blog_id
	 * @param unknown_type $user_id
	 */
	public function exist_love($blog_id, $user_id)
	{
		$query = $this->db->get_where('love', array('blog_id'=>$blog_id, 'user_id'=>$user_id));
		if($query->num_rows()==0)return "add";
		return "noadd";
	}
	
}