<?php $this->load->helper('form');?>
<?php $this->load->library('session');?>
<div id="header_wrapper">
<div id="header_image"><img src="<?php echo base_url('resource/images/header.jpg');?>"/></div>

<div id="nav">
<div id="nav_word">
   <a class="a2" href="<?php echo base_url('index.php/momo/blog/home') ?>">Home
   </a>
   
   <a class="a2" href="<?php echo base_url('index.php/momo/blog/personal/'.$this->session->userdata('user_id')); ?>">
   <?php echo $this->session->userdata('blog_name');?>
   </a>
   <a class="a2" href="<?php echo base_url('index.php/momo/tag/explore') ?>">Explore</a>   
   <a class="a2" href="<?php echo base_url('index.php/momo/user/user_exit/'.$this->session->userdata('user_id'));?>">Exit</a>
   
   </div>
   <div id="description">
   <pre>
        
        I am here 
        where are you ?</pre>
   </div>
</div>
<div id="face_image" onMouseOver="show_publisher()" onMouseOut="hide_publisher()" ><img src="<?php echo base_url('resource/images/face.jpg');?>" /></div>
</div>  

<p class="clear"></p>