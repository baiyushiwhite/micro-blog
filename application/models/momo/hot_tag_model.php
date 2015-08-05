<?php
class hot_tag_Model extends CI_Model{
	var $tag, $heat;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 获得热门标签列表，10个，根据搜索次数排序
	 */
	public function get_hot_tags()
	{
		$sql = "SELECT * FROM hot_tag order by heat desc limit 10";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	/**
	 * 根据传入的标签，增加该标签的热度
	 * @param unknown_type $tag
	 */
	public function add_hot_tag($tag)
	{
		$query = $this->db->get_where('hot_tag', array('tag' => $tag));
		if($query->num_rows()==0){
			//该标签不存在
			$this->tag = $tag;
			$this->heat = 1;
			$this->db->insert('hot_tag', $this);
		}else{
			$hot_tag = $query->row();
			$heat = $hot_tag->heat;
			$heat++;
			$data = array(
					'heat' => $heat
			);
			$this->db->where('tag', $tag);
			$this->db->update('hot_tag', $data);
		}
	}
	
	
	
}