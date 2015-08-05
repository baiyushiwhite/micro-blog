function checkUserId(text){
	var user_id = text.value;
	if(user_id==null||user_id==''){
		document.getElementById("remindInfo1").innerText = "输入账号为空";
		text.focus();
		return;
	}
	var xhr = new XMLHttpRequest();
	var send_string="user_id=" + text.value; 
	xhr.onreadystatechange = function(){
		if(xhr.readyState==4 && xhr.status == 200){
			var result = xhr.responseText;
			document.getElementById("remindInfo1").innerText = result;
		}
	}
	xhr.open("get", "../user/check_user_id?"+send_string);
	xhr.send();
}

function checkPassword(password2){
	var firstPassword = document.getElementById("password1").value;
	var secondPassword = password2.value;
	if(firstPassword!=secondPassword){
		document.getElementById("remindInfo2").innerText = "两次输入密码不一致";
	}else{
		document.getElementById("remindInfo2").innerText = "";
	}
}

function follow(follower, followee){
	var xhr = new XMLHttpRequest();
	var send_string="follower=" + follower + "&followee="+ followee;
	var current_relation = document.getElementById("follow").innerText;
	xhr.onreadystatechange = function(){ 
		if(xhr.readyState==4 && xhr.status == 200){
			var result = xhr.responseText;
			document.getElementById("follow").innerText = result;
		}
	}
	if(current_relation=="follow"){
		xhr.open("get", "../../user/create_follow_relation?"+send_string);
	}else if(current_relation=="cancle follow"){
		xhr.open("get", "../../user/cancle_follow_relation?"+send_string);
	}
	xhr.send();
}

function cancle_follow(follower, followee){
	var xhr = new XMLHttpRequest();
	var send_string="follower=" + follower + "&followee="+ followee;
	xhr.onreadystatechange = function(){ 
		if(xhr.readyState==4 && xhr.status == 200){
			$("#"+"ifollow_"+followee).fadeOut(1500);
		}
	}
	xhr.open("get", "../../momo/user/cancle_follow_relation?"+send_string);
	xhr.send();
}
function show_panel(id){
	$("#"+id).slideToggle(1000);
	if(id=="login"){
		$("#register").slideToggle(1800);
	}
	if(id=="register"){
		$("#login").slideToggle(1800);
	}
}