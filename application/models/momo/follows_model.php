<?php
class Follows_model extends CI_Model{
	var $follower_id, $followee_id, $follower_blog_name, $followee_blog_name;
	
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 向数据库中添加一对关注关系
	 * @param unknown_type $follower
	 * @param unknown_type $followee
	 */
	public function insert_follow($follower, $followee, $follower_blog_name, $followee_blog_name)
	{
		$this->follower_id = $follower;
		$this->followee_id = $followee;
		$query = $this->db->get_where('follows', array('follower_id'=>$follower, 'followee_id'=>$followee));
		$num = $query->num_rows();
		if($num == 0){
			$this->follower_blog_name = $follower_blog_name;
			$this->followee_blog_name = $followee_blog_name;
			$this->db->insert('follows', $this);
		}
		return "cancle follow";
	}
	
	/**
	 * 获得两个用户的关系
	 * @param unknown_type $follower
	 * @param unknown_type $followee
	 */
	public function get_follow($follower, $followee)
	{
		if($follower == $followee){
			return "SELF";
		}
		$query = $this->db->get_where('follows', array('follower_id'=>$follower, 'followee_id'=>$followee));
	    $num = $query->num_rows();
		if($num > 0){
			return "cancle follow";
		}else{
			return "follow";
		}
	}
	
	/**
	 * 取消关注
	 * @param unknown_type $follower
	 * @param unknown_type $followee
	 */
	public function delete_follow($follower, $followee)
	{
		$query = $this->db->get_where('follows', array('follower_id'=>$follower, 'followee_id'=>$followee));
		$num = $query->num_rows();
		while($num > 0){
			 $this->db->delete('follows', array('follower_id'=>$follower, 'followee_id'=>$followee));
			 $query = $this->db->get_where('follows', array('follower_id'=>$follower, 'followee_id'=>$followee));
			 $num = $query->num_rows();
		}
		return "follow";
	}
	
	/**
	 * 根据传入的user_id获得该user关注的博客列表
	 * @param unknown_type $current_user_id
	 */
	public function get_ifollow($current_user_id)
	{
		$query = $this->db->get_where('follows',array('follower_id'=>$current_user_id));
		$ifollows = null;
		if($query->num_rows() > 0){
			return $query->result();
		}
	}
	
	/**
	 * 根据传入的user_id获得该user关注的博客的个数
	 * @param unknown_type $current_user_id
	 */
	public function get_ifollow_count($current_user_id)
	{
		$query = $this->db->get_where('follows',array('follower_id'=>$current_user_id));
		return $query->num_rows();
	}
	
	
}