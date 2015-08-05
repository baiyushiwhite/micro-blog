<?php if ($ifollow_list!=null):?>
<?php foreach ($ifollow_list as $ifollow):?>
<?php echo $ifollow->followee_blog_name;?>
<?php endforeach;?>
<?php endif;?>