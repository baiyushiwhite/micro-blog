<?php $this->load->helper('form');?>
<?php $this->load->library('session');?>
<div id="header_wrapper" style="display:none;">
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
   <br/>
        I am here 
        where are you ?</pre>
   </div>
</div>
<div id="face_image" onMouseOver="show_publisher()" onMouseOut="hide_publisher()" ><img src="<?php echo base_url('resource/images/face.jpg');?>" /></div>
</div>  

<p class="clear"></p>

<div id="publisher" onMouseOver="stop_animate()" onMouseOut="start_animate()">
   <?php 
   $attributes = array('class' => 'a2');
   echo anchor('momo/blog/new_article_blog','Publish',$attributes);?>
</div>
<div id="main_wrapper">
    <div id="left_side">
        <div id="fresh_blog_list">
            <?php if($blog_list!=null):?>
            <?php foreach ($blog_list as $blog):?>
                <div class="blog_wrapper">
                <div class="tag_pane">
                <?php
                 $tag_list = explode("\n", $blog->tags);
                 foreach ($tag_list as $tag):
                 ?>
                 <li class="blog_tag">
	             <a href="<?php echo base_url("index.php/momo/tag/search?tag=".$tag);?>">
	             <?php echo $tag;?>
	             </a>
                 <?php endforeach;?>
                 </div>
                 
                
                <div class="blog_content_wrapper">
                
                <div class="blog_header" id="blog_header<?php echo $blog->id;?>" onclick='show_panel("blog_content<?php echo $blog->id;?>")'>
                
                <span class="title">
                <?php 
                $typestr=$blog->type;
                $str_list = explode("#", $typestr);
                $type = $str_list[0];
                if($type=="convey"){
                    $attributes = array('class' => 'a1');
                	echo anchor('momo/blog/show/'.$str_list[3], $blog->title, $attributes);
                }else{
                	$attributes = array('class' => 'a1');
                	echo anchor('momo/blog/show/'.$blog->id, $blog->title, $attributes);
                }
                ?>
                </span>
                
                <span class="author">
                <?php 
                $typestr=$blog->type;
                $str_list = explode("#", $typestr);
                $type = $str_list[0];
                if($type=="convey"){
                	$attributes = array('class' => 'a6');
                	echo anchor('momo/blog/personal/'.$blog->user_id, $blog->blog_name, $attributes);
                	echo " carry through  ";
                	echo anchor('momo/blog/personal/'.$str_list[1], $str_list[2], $attributes);
                	echo " reason ：";
                	echo $str_list[4];
                }else{
                    $attributes = array('class' => 'a6');
                	echo anchor('momo/blog/personal/'.$blog->user_id, $blog->blog_name, $attributes);
                }
                ?>
                </span>
                
                </div>
                <p class="clear"></p>
                <div class="blog_content" id="blog_content<?php echo $blog->id;?>">
                <img src="<?php echo base_url('resource/images/quote_begin.png');?>"/>
                <p>
                <?php echo $blog->content;?>
                </p>
                
                <img src="<?php echo base_url('resource/images/quote_after.png');?>" style="float:right;"/>
                
                <p class="clear"></p>
                <I class="time">
                <?php echo $blog->create_time;?>
                </I>
                </div>
                </div>
                <div class="heat_info_wrapper">
                        <span class="heat"><a>heat(<span
                                id="intheat<?php echo $blog->id;?>"><?php echo $blog->heat;?>℃</span>)</a></span>
                        <span class="reply" onclick='show_reply_panel("<?php echo $blog->id;?>")'><a>reply(<span
                                id="intreply<?php echo $blog->id;?>"><?php echo $blog->reply_num;?></span>)</a></span>
                                
                        <span class="convey"><?php 
                        $typestr=$blog->type;
                        $str_list = explode("#", $typestr);
                        $type = $str_list[0];
                        if($type=="convey"){
                            echo anchor('momo/blog/convey/'.$str_list[3], "carry($blog->convey_num)");
                        }else{
                        	echo anchor('momo/blog/convey/'.$blog->id, "carry($blog->convey_num)");
                        }
                        ?>
                        </span>
                        <span class="love"><a id="love<?php echo $blog->id;?>"
                                              onclick='love("<?php echo $blog->id;?>")'>love</a></span>

                        <div id="reply<?php echo $blog->id;?>" style="display:none;">
                       
                            <div class="reply_input" id="reply_input<?php echo $blog->id;?>">
                                <span id="new_reply_to<?php echo $blog->id;?>"></span>
                                <textarea rows="3" cols="83" name="new_reply_content"
                                          id="new_reply_content<?php echo $blog->id;?>">
                                </textarea>
                                <br/>
                                <button type="button" class="button"
                                        onclick='add_reply("<?php echo $blog->id;?>", "<?php echo $current_user->user_id;?>")'>reply</button>
                            </div>
                            <br/>
                            <div class="reply_list_label">reply list</div>
                            <div class="reply_list" id="reply_list<?php echo $blog->id;?>"></div>
                        </div>
                        
                        
                        <div class="love_list" id="love_list<?php echo $blog->id;?>" style="display:none;">
                        <br/>
                        <div class="love_list_label">love list</div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            <?php endif;?>
           
        </div><!-- end fresh_blog_list -->
    </div><!-- end left_side -->

    <div class="right_side">
        <div id="side_ifollow">
            <span onclick='show_panel("ifollow")' class="lilabel" id="followlabel">
                I follow ...
            </span>
            <div id="ifollow">
            <?php if ($ifollow_list!=null):?>
                  <?php foreach ($ifollow_list as $ifollow):?>
                  
                  <li id="ifollow_<?php echo $ifollow->followee_id;?>" onMouseOver='show_cancle("cancle_follow<?php echo $ifollow->followee_id;?>")' onMouseOut='hide_cancle("cancle_follow<?php echo $ifollow->followee_id;?>")'>
                  <?php 
                  $attributes = array('class' => 'a3');
                  echo anchor('momo/blog/personal/'.$ifollow->followee_id, $ifollow->followee_blog_name, $attributes);
                  ?>
                  
                  <a onclick='cancle_follow("<?php echo $ifollow->follower_id;?>", "<?php echo $ifollow->followee_id;?>")' class="cancle" id="cancle_follow<?php echo $ifollow->followee_id;?>" style="display:none;">remove</a>
                  </li>
                  
                  <?php endforeach;?>
                  <?php endif;?>
            </div>
        </div>

        <div id="side_taglist">
        <span onclick='show_panel("mytag")' class="lilabel">
              My tags ...
        </span>
        <div id="mytag">
        <?php if ($my_tag_list!=null):?>
        <?php foreach ($my_tag_list as $tag):?>
            <li id="tag_<?php echo $tag->tag;?>" onMouseOver='show_cancle("cancle_subscribe<?php echo $tag->tag;?>")' onMouseOut='hide_cancle("cancle_subscribe<?php echo $tag->tag;?>")'>
            <a class='a3' href='<?php echo base_url("index.php/momo/tag/search/?tag=".$tag->tag)?>'>
            <?php echo $tag->tag;?>
            </a>
            <a onclick='cancle_subscribe("<?php echo $tag->tag;?>", "<?php echo $tag->user_id;?>")' class="cancle" id="cancle_subscribe<?php echo $tag->tag;?>" style="display:none;">remove</a>
            </li>
        <?php endforeach;?>
        <?php endif;?>
        </div>
        </div>
    </div><!-- end rihgt_side -->
     
</div><!-- end mian_wrapper -->

<p class="clear"></p>

<script>
$('.blog_content img').css('max-width','550px');
$('#header_wrapper').slideToggle(1000);
</script>