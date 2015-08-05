<?php
class Tag_blog_model extends CI_Model{
	var $blog_id, $tag_name;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 插入新的blog和tag的关系
	 * @param unknown_type $blog_id
	 * @param unknown_type $tag
	 */
	public function insert_tag_blog($blog_id, $tag)
	{
		$this->blog_id = $blog_id;
		$this->tag_name = $tag;
		$this->db->insert('tag_blog', $this);
	}
	
	/**
	 * 通过传入的tag，返回tag中包含该tag的blog列表，按照时间先后顺序排列
	 * @param unknown_type $tag
	 */
	function get_blogs_by_tag($tag)
	{
		$query = $this->db->get('tag_blog');
		$tag_blog_count = $query->num_rows();
		if($tag_blog_count!=0){
			$sql = "select DISTINCT  blog.id,blog.create_time,blog.user_id,blog.blog_name,blog.title,blog.content,blog.type,blog.tags,blog.heat,blog.reply_num,blog.convey_num
			from blog,tag_blog where 
			tag_blog.tag_name = '$tag' AND tag_blog.blog_id = blog.id
			order by blog.create_time desc";
//             $query = $this->db->get_where('tag_blog', array('tag_name'=>$tag));
			$query = $this->db->query($sql);
//             $id_list 
//             foreach ($query)
			return $query->result();
		}else{
			return null;
		}

	}
	
}