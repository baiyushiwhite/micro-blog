<?php if($to_follow!="SELF"):?>
<a id ="follow" class="follow" onclick='follow("<?php echo $this->session->userdata('user_id');?>","<?php echo $user->user_id;?>")'><?php echo $to_follow;?></a>
<?php endif;?>
<a class="follow" href="<?php echo base_url('index.php/momo/blog/home') ?>">Home
</a>
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

</div><!-- end mian_wrapper -->

<p class="clear"></p>

<script>
$('.blog_content img').css('max-width','550px');
$('#header_wrapper').slideToggle(1000);
</script>