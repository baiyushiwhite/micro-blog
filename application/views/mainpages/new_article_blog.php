<?php $this->load->helper('form');?>
<div id="new_article_wrapper">
<?php
$attributes = array('class' => 'form', 'id'=>'new_article_form');
echo form_open('momo/blog/publish_article_blog',$attributes);
?>
<div id="title_wrapper">
<?php echo form_label('title(must)')?>
<br/>
<?php echo form_input('title', set_value('title'), 'class="input"');
?>
</div>

<div id="editor_wrapper">
<textarea name="content" style="width:700px;height:600px;visibility:hidden;" value="<?php echo set_value('content');?>" ></textarea>
</div>

<div id="tag_wrapper">
<?php echo form_label('tags')?>
<br/>
<?php 
$attrs = array(
              'name'        => 'edit_tags',
              'id'   => 'edit_tags',
              'rows'        => '10',
              'cols'        => '28'
            );
$js = 'onkeydown = "splite_tags(event)"';
echo form_textarea($attrs, set_value('edit_tags'), $js)?>

</div>
<div id="tags"></div>
<?php 
$attributes = array('class'=>'button');
$checkjs = 'onblur="checkBlog()"';
echo form_submit($attributes,'submit',$checkjs);
echo form_close();
?>
</div>
<p class="clear"></p>
<script>
var all_tag_str = document.getElementById("edit_tags").value;
var tag_list = all_tag_str.split('\n');
var tag_html = "";
for(var i = 0;i<tag_list.length;i++){
	tag_html = tag_html + "<li>"+tag_list[i]+"</li>";
}
document.getElementById("tags").innerHTML = tag_html;
</script>