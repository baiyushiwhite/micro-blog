<?php
class Reply_model extends CI_Model{
	var $blog_id, $to_id, $from_id, $from_blog_name, $to_blog_name, $content, $time;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('date');
		$this->load->database();
	}
	/**
	 * 插入新的回复
	 * @param unknown_type $blog_id
	 * @param unknown_type $to_id
	 * @param unknown_type $from_id
	 * @param unknown_type $content
	 */
	public function insert_reply($blog_id, $to_id, $from_id, $from_blog_name, $to_blog_name, $content)
	{
		$this->blog_id = $blog_id;
		$this->from_id = $from_id;
		$this->to_id = $to_id;
		$this->from_blog_name = $from_blog_name;
		$this->to_blog_name = $to_blog_name;
		$this->content = $content;
		date_default_timezone_set("PRC");
		$this->time = date("Y-m-d H:i:s");
		$this->db->insert('reply', $this);
		return "OK";
	}
	
	/**
	 * 根据传入找到该blog所有的回复
	 * @param unknown_type $blog_id
	 */
	public function get_reply_by_blog_id($blog_id)
	{
		$this->db->select('*');
		$this->db->from('reply');
		$this->db->where('blog_id',$blog_id);
		$this->db->order_by("time", "desc");
		$query = $this->db->get();
		$result = null;
		if($query->num_rows()>0){
			$result =  $query->result();
		}
		return $result;
	}
}
