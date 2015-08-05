<?php $this->load->helper('form');?>

<div id="convey_article_wrapper">
<?php
$attributes = array('class' => 'form', 'id'=>'new_article_form');
echo form_open('momo/blog/convey_confirm',$attributes);
?>
<div id="title_wrapper">
<?php echo form_label('title(must)')?>
<br/>
<?php echo form_input('title', '', 'class="input"');
?>
</div>
<?php echo form_label('reason')?>
<br/>
<div id="convey_reason">
    <textarea name="convey_reason" style="width:700px;height:100px;"></textarea>
</div>
<br/>
<div id="editor_wrapper">
    <textarea name="content" style="width:700px;height:700px;visibility:hidden;"><?php echo $content;?></textarea>
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
echo form_textarea($attrs, '', $js)?>

</div>
<div id="tags"></div>

<?php 
        $data = array(
		'source_id'  => $source_id,
		'source_name' => $source_name,
        'source_blog_id'  => $source_blog_id
);
echo form_hidden($data);
?>

<?php 
$attributes = array('class'=>'button');
$checkjs = 'onblur="checkBlog()"';
echo form_submit($attributes,'submit',$checkjs);
echo form_close();
?>
</div>
<p class="clear"></p>