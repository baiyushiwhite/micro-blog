<?php $this->load->helper('form');?>
<?php
$attributes = array('class' => 'form', 'id'=>'register_form');
echo form_open('momo/user/register',$attributes);
?>
<p>
<?php
echo form_label('账号');
$useridjs = 'onblur="checkUserId(this)"';
echo form_input('user_id', '',$useridjs);
?>
<span id="remindInfo1"></span>
</p>
<?php
echo form_label('微博名');
echo form_input('blog_name', '', 'id="blog_name"');
?>
</p>
<p>
<?php
echo form_label('密码');
echo form_password('password1', '', 'id="password1"');
?>
</p>
<p>
<?php
echo form_label('确认密码');
$passwordjs = 'onblur="checkPassword(this)"';
echo form_password('password2', '', $passwordjs);
?>
<span id="remindInfo2"></span>
</p>
<?php
echo form_label('描述');
echo form_textarea('description', '', 'id="description"');
?>
</p>
<p>
<?php
echo form_submit('submit','注册');
echo form_close();
?>
</p>