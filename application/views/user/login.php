<?php $this->load->helper('form');?>

<div id="login_wrapper" class="user">
<div id="login_title" class="div_hover" onclick='show_panel("login")'>
<img src="<?php echo base_url('resource/images/login.png');?>"/>
<span class="remindInfo">momo login</span>
</div>
<div id="login">
<?php
$attributes = array('class' => 'form', 'id'=>'login_form');
echo form_open('momo/user/login',$attributes);
?>
<p class="input">
<?php
echo form_label('id');
echo "<br/>";
echo form_input('user_id', '', 'id="user_id"');
?>
</p>
<p class="input">
<?php
echo form_label('password');
echo "<br/>";
echo form_password('password', '', 'id="password"');
?>
</p>
<p>
<?php if($remindInfo!=null&&$remindInfo!=''):?>
<span class="warnInfo" ><?php echo $remindInfo;?></span>
<?php endif;?>
</p>
<p class="input">
<?php
$attributes = array('class' => 'button');
echo form_submit($attributes,'login');
echo form_close();
?>
</p>
</div><!-- end login -->
</div><!-- end login_wrapper -->

<div id="register_wrapper" class="user">
<div class="div_hover" onclick='show_panel("register")'>
<img src="<?php echo base_url('resource/images/register.png');?>"/>
<span class="remindInfo"> here for no account </span>
</div>
<div id="register" style="display:none;">
<?php
$attributes = array('class' => 'form', 'id'=>'register_form');
echo form_open('momo/user/register',$attributes);
?>
<p class="input">
<?php
echo form_label('id');
echo "<br/>";
$useridjs = 'onblur="checkUserId(this)"';
echo form_input('user_id', '',$useridjs);
?>
<span id="remindInfo1" class="warnInfo"></span>
</p>
<p class="input">
<?php
echo form_label('blog_name');
echo "<br/>";
echo form_input('blog_name', '', 'id="blog_name"');
?>
</p>
<p class="input">
<?php
echo form_label('password');
echo "<br/>";
echo form_password('password1', '', 'id="password1"');
?>
</p>
<p class="input">
<?php
echo form_label('confirm password');
echo "<br/>";
$passwordjs = 'onblur="checkPassword(this)"';
echo form_password('password2', '', $passwordjs);
?>
<span id="remindInfo2" class="warnInfo" ></span>
</p>
<p class="input_area">
<?php
echo form_label('description');
echo "<br/>";
echo form_textarea('description', '', 'id="description"');
?>
</p>
<p class="input">
<?php
$attributes = array('class' => 'button');
echo form_submit($attributes,'register');
echo form_close();
?>
</p>
</div><!-- end register -->
</div><!-- end register_wrapper -->