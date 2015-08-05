<?php
class Blog_model extends CI_Model{
	var $id, $create_time, $user_id, $blog_name, $title, $content, $type, $tags, $heat, $reply_num, $convey_num;
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('date');
		$this->load->database();
	}
	
	/**
	 * 查找当前用户的所有新鲜事，
	 * 包括该用户关注者发布的博客
	 * 订阅标签相关的博客
	 * 自己发布的博客
	 * 按时间的逆序排列
	 */
	public function get_fresh_blog_list($current_user_id)
	{
		$query = $this->db->get('follows');
		$follow_count = $query->num_rows();
		$query = $this->db->get('tag_user');
		$tag_user_count = $query->num_rows();
		$query = $this->db->get('tag_blog');
		$tag_blog_count = $query->num_rows();
		
		if($follow_count==0&&$tag_user_count==0&&$tag_blog_count==0){
			$this->db->where('user_id', $current_user_id);
			$this->db->order_by('create_time', 'desc'); 
			$query = $this->db->get('blog');
			return $query->result();
		}
		if($follow_count!=0&&$tag_user_count==0&&$tag_blog_count==0){
			 $sql = "select DISTINCT blog.id,blog.create_time,blog.user_id,blog.blog_name,blog.title,blog.content,blog.type,blog.tags,blog.heat,blog.reply_num,blog.convey_num
		             from blog,follows where (blog.user_id = '$current_user_id') 
		             OR (follows.follower_id = '$current_user_id' AND blog.user_id = follows.followee_id)
		             order by blog.create_time desc";
			 $query = $this->db->query($sql);
			 return $query->result();
		}
	    if($follow_count==0&&$tag_user_count!=0&&$tag_blog_count==0){
	    	$this->db->where('user_id', $current_user_id);
			$this->db->order_by('create_time', 'desc'); 
			$query = $this->db->get('blog');
			return $query->result();
	    }
		if($follow_count==0&&$tag_user_count==0&&$tag_blog_count!=0){
			$this->db->where('user_id', $current_user_id);
			$this->db->order_by('create_time', 'desc'); 
			$query = $this->db->get('blog');
			return $query->result();
		}
	    if($follow_count==0&&$tag_user_count!=0&&$tag_blog_count!=0){
	    	$sql = "select DISTINCT  blog.id,blog.create_time,blog.user_id,blog.blog_name,blog.title,blog.content,blog.type,blog.tags,blog.heat,blog.reply_num,blog.convey_num
	    	from blog,tag_blog,tag_user where (blog.user_id = '$current_user_id')
	    	OR (tag_user.user_id = '$current_user_id' AND tag_blog.tag_name = tag_user.tag AND tag_blog.blog_id = blog.id)
	    	order by blog.create_time desc";
	    	$query = $this->db->query($sql);
	    	return $query->result();
		}
	    if($follow_count!=0&&$tag_user_count==0&&$tag_blog_count!=0){
	    	$sql = "select DISTINCT blog.id,blog.create_time,blog.user_id,blog.blog_name,blog.title,blog.content,blog.type,blog.tags,blog.heat,blog.reply_num,blog.convey_num
	    	from blog,follows where (blog.user_id = '$current_user_id')
	    	OR (follows.follower_id = '$current_user_id' AND blog.user_id = follows.followee_id)
	    	order by blog.create_time desc";
	    	$query = $this->db->query($sql);
	    	return $query->result();
	    }
		if($follow_count!=0&&$tag_user_count!=0&&$tag_blog_count==0){
			$sql = "select DISTINCT blog.id,blog.create_time,blog.user_id,blog.blog_name,blog.title,blog.content,blog.type,blog.tags,blog.heat,blog.reply_num,blog.convey_num
			from blog,follows where (blog.user_id = '$current_user_id')
			OR (follows.follower_id = '$current_user_id' AND blog.user_id = follows.followee_id)
			order by blog.create_time desc";
			$query = $this->db->query($sql);
			return $query->result();
		}
		if($follow_count!=0&&$tag_user_count!=0&&$tag_blog_count!=0){
			$sql = "select DISTINCT  blog.id,blog.create_time,blog.user_id,blog.blog_name,blog.title,blog.content,blog.type,blog.tags,blog.heat,blog.reply_num,blog.convey_num
			from blog,follows,tag_blog,tag_user where (blog.user_id = '$current_user_id')
			OR (follows.follower_id = '$current_user_id' AND blog.user_id = follows.followee_id)
			OR (tag_user.user_id = '$current_user_id' AND tag_blog.tag_name = tag_user.tag AND tag_blog.blog_id = blog.id)
			order by blog.create_time desc";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
	}
	
	/**
	 * 向数据库中新添一篇博客
	 * @param unknown_type $title
	 * @param unknown_type $content
	 * @param unknown_type $tags
	 */
	public function insert_blog($blog_name, $title, $content, $tags)
	{
		$this->user_id = $this->session->userdata('user_id');
		$this->blog_name = $blog_name;
		$this->title = $title;
		$this->content = $content;
		date_default_timezone_set("PRC");
		$this->create_time = date("Y-m-d H:i:s");
		$this->type = "text";
		$this->tags = $tags;
		$this->reply_num = 0;
		$this->heat = 0;
		$this->convey_num = 0;
		$this->db->insert('blog', $this);
		$current_blog_id = mysql_insert_id();
		return $current_blog_id;
	}
	
	/**
	 * 根据传入的id获得相应博文
	 * @param unknown_type $blog_id
	 */
	public function get_blog($blog_id)
	{
		$query = $this->db->get_where('blog', array('id'=>$blog_id));
		$num = $query->num_rows();
		if($num > 0){
			return $query->row();
		}
	}
	
	/**
	 * 返回该user_id发布的所有blog
	 * @param unknown_type $user_id
	 */
	public function get_blogs_by_user($user_id)
	{
		$query = $this->db->get_where('blog', array('user_id'=>$user_id));
        return $query->result();
	}
	
	/**
	 * 根据传入的id将相应的博客的heat加一
	 * @param unknown_type $blog_id
	 */
	public function add_reply($blog_id)
	{
		$query = $this->db->get_where('blog', array('id'=>$blog_id));
		$blog = $query->row();
		$heat = $blog->heat;
		$heat = $heat + 1; 
		$reply = $blog->reply_num;
		$reply = $reply + 1;
		$data = array(
				'heat' => $heat,
				'reply_num' => $reply
		);
		$this->db->where('id', $blog_id);
        $this->db->update('blog', $data); 
	}
	
	/**
	 * 转载博客
	 * @param unknown_type $source_id
	 * @param unknown_type $blog_name
	 * @param unknown_type $title
	 * @param unknown_type $content
	 */
	public function convey_blog($source_id, $source_name, $blog_name, $title, $content, $tags, $source_blog_id, $convey_reason)
	{
		$this->user_id = $this->session->userdata('user_id');
		$this->blog_name = $blog_name;
		$this->title = $title;
		$this->content = $content;
		date_default_timezone_set("PRC");
		$this->create_time = date("Y-m-d H:i:s");
		$this->type = "convey#$source_id#$source_name#$source_blog_id#$convey_reason";
		$this->tags = $tags;
		$this->reply_num = 0;
		$this->heat = 0;
		$this->convey_num = 0;
		$this->db->insert('blog', $this);
		$current_blog_id = mysql_insert_id();
		return $current_blog_id;
	}
	
	/**
	 * 根据传入的id将相应博客的转载数加一
	 * @param unknown_type $blog_id
	 */
	public function add_convey($blog_id)
	{
		$query = $this->db->get_where('blog', array('id'=>$blog_id));
		$blog = $query->row();
		$heat = $blog->heat;
		$heat = $heat + 1;
		$convey_num = $blog->convey_num;
		$convey_num = $convey_num + 1;
		$data = array(
				'heat' => $heat,
				'convey_num' => $convey_num
		);
		$this->db->where('id', $blog_id);
		$this->db->update('blog', $data);
		
		$type = $blog->type;
		$str_list = explode(",", $type);
		while ($str_list[0]=="convey") {
			$source_blog_id = $str_list[3];
			$query = $this->db->get_where('blog', array('id'=>$source_blog_id));
			$blog = $query->row();
			$heat = $blog->heat;
			$heat = $heat + 1;
			$convey_num = $blog->convey_num;
			$convey_num = $convey_num + 1;
			$data = array(
					'heat' => $heat,
					'convey_num' => $convey_num
			);
			$this->db->where('id', $source_blog_id);
			$this->db->update('blog', $data);
			$type = $blog->type;
			$str_list = explode(",", $type);
		}
	}
	
	/**
	 * 根据传入的id增加该blog的喜欢数
	 * @param unknown_type $blog_id
	 */
	public function add_love($blog_id)
	{
		$query = $this->db->get_where('blog', array('id'=>$blog_id));
		$blog = $query->row();
		$heat = $blog->heat;
		$heat = $heat + 1;
		$data = array(
				'heat' => $heat
		);
		$this->db->where('id', $blog_id);
		$this->db->update('blog', $data);
	}
	
	/**
	 * 获得热门标签的所有博客
	 */
	public function get_hot_tag_blogs()
	{
		$sql = "select tag FROM hot_tag order by heat desc limit 10";
		$tag_list = $this->db->query($sql)->result();
		$tag_sql = "(";
		if($tag_list!=null||$tag_list->num_rows()>0){
			$tag_sql = "('".$tag_list[0]->tag."'";
			foreach ($tag_list as $tag){
				$tag_sql = $tag_sql.","."'$tag->tag'";
			}
		}
		$tag_sql = $tag_sql.")";
		
		$sql = "select DISTINCT blog.id,blog.create_time,blog.user_id,blog.blog_name,blog.title,blog.content,blog.type,blog.tags,blog.heat,blog.reply_num,blog.convey_num
				from blog,hot_tag,tag_blog 
				where blog.id = tag_blog.blog_id AND tag_blog.tag_name 
				IN ".$tag_sql." order by blog.create_time desc";
		$query = $this->db->query($sql);
		return $query->result();
	}
}