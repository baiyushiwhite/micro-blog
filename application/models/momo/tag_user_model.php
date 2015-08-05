<?php
class tag_user_model extends CI_Model{
	var $tag, $user_id;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 根据传入的user_id，获得该user的所有订阅的tag
	 * @param unknown_type $current_user_id
	 */
	public function get_tag_list($current_user_id)
	{
		$query = $this->db->get_where('tag_user',array('user_id'=>$current_user_id));
		$result = NULL;
		if($query->num_rows() > 0){
			$result = $query->result();
		}
		return $result;
	}
	
	/**
	 * 获得该user的订阅的tag数量
	 * @param unknown_type $current_user_id
	 */
	public function get_tag_count($current_user_id)
	{
		$query = $this->db->get_where('tag_user',array('user_id'=>$current_user_id));
		return $query->num_rows();
	}
	
	/**
	 * 判断传入的tag是否包含在当前用户已订阅的tag列表中
	 * @param unknown_type $current_tag
	 * @param unknown_type $current_user_id
	 */
	public function in_my_tag($current_tag, $current_user_id)
	{
		$query = $this->db->get_where('tag_user',array('tag'=>$current_tag, 'user_id'=>$current_user_id));
		return ($query->num_rows());
	}
	
	/**
	 * 插入新的订阅
	 * @param unknown_type $tag
	 * @param unknown_type $user_id
	 * @return string
	 */
	public function insert_tag_user($tag, $user_id)
	{
		$query = $this->db->get_where('tag_user',array('tag'=>$tag, 'user_id'=>$user_id));
		if (!$query->num_rows()){
			$this->tag = $tag;
			$this->user_id = $user_id;
			$this->db->insert('tag_user', $this);
		}
		return "";
	}
	
	/**
	 * 删除该订阅关系
	 * @param unknown_type $tag
	 * @param unknown_type $user_id
	 */
	public function delete_tag_user($tag, $user_id)
	{
		$this->db->delete('tag_user', array('tag'=>$tag, 'user_id'=>$user_id));
		return "OK";
	}
	

}