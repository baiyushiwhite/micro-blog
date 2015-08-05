<?php
echo $blog->blog_name;
?>
<?php 
echo $blog->content;
?>
<?php 
echo $blog->time;
?>
<?php 
echo $blog->user_id;
?>
<?php 

?>
<?php 
echo $blog->reply_num;
?>
<?php 
echo $blog->convey_num;
?>
<div id="heat_info_wrapper">
<span class="heat">热度(<?php echo $blog->heat;?>)</span>
<span class="reply">回应(<?php echo $blog->reply_num;?>)</span>
<span class="heat">转载(<?php echo $blog->convey_num;?>)</span>
</div>