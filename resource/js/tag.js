function check_tag(t){
	if(t.value==""){
		t.value = "search tag you love";
	}
}
function begin_input(t){
	if(t.value=="search tag you love"){
		t.value = "";
	}
}

function subscribe(tag, user_id){
	var xhr = new XMLHttpRequest();
	var send_string="tag=" + tag + "&user_id="+ user_id;
	var current_relation = document.getElementById("follow").innerText;
	xhr.onreadystatechange = function(){ 
		if(xhr.readyState==4 && xhr.status == 200){
			var result = xhr.responseText;
			document.getElementById("follow").innerText = result;
		}
	}
	if(current_relation=="subscribe"){
		xhr.open("get", "../tag/create_subscribe?"+send_string);
	}else if(current_relation=="cancle subscribe"){
		xhr.open("get", "../tag/cancle_subscibe?"+send_string);
	}
	
	xhr.send();
}


function cancle_subscribe(tag, user_id){
	var xhr = new XMLHttpRequest();
	var send_string="tag=" + tag + "&user_id="+ user_id;
	xhr.onreadystatechange = function(){ 
		if(xhr.readyState==4 && xhr.status == 200){
			var result = xhr.responseText;
			if(result=="subscribe"){
				$("#"+"tag_"+tag).fadeOut(1500);
			}
			
		}
	}
	xhr.open("get", "../tag/cancle_subscibe?"+send_string);
	xhr.send();
}