<html>
	<head>
		<title>Momo Microblog</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="<?php echo base_url("resource/js/user.js")?>"></script>
		<script type="text/javascript" src="<?php echo base_url("resource/js/blog.js")?>"></script>
		<script type="text/javascript" src="<?php echo base_url("resource/js/tag.js")?>"></script>
	    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resource/css/Style.css")?>" />
        <link rel="stylesheet" href="<?php echo base_url("resource/kindeditor/themes/default/default.css")?>" />
        <link rel="stylesheet" href="<?php echo base_url("resource/kindeditor/plugins/code/prettify.css")?>" />
        <script charset="utf-8" src="<?php echo base_url("resource/kindeditor/kindeditor.js")?>"></script>
        <script charset="utf-8" src="<?php echo base_url("resource/kindeditor/lang/zh_CN.js")?>"></script>
        <script charset="utf-8" src="<?php echo base_url("resource/kindeditor/plugins/code/prettify.js")?>"></script>
        <script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="content"]', {
				cssPath : '<?php echo base_url("resource/kindeditor/plugins/code/prettify.css")?>',
				//uploadJson : '../php/upload_json.php',
				//fileManagerJson : '../php/file_manager_json.php',
				allowFileManager : true,
				themeType : 'simple',
				afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
					K.ctrl(self.edit.doc, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
				},
				items : [
							'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
							'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
							'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'flash', 'media']
					
			});
			prettyPrint();
		});
	</script>	
</head>
	<body>
		<hr/>