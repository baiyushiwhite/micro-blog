function splite_tags(e){
	var currKey=e.keyCode||e.which||e.charCode;
	if(currKey==13){
		var all_tag_str = document.getElementById("edit_tags").value;
		var tag_list = all_tag_str.split('\n');
		var tag_html = "";
		for(var i = 0;i<tag_list.length;i++){
			tag_html = tag_html + "<li>"+tag_list[i]+"</li>";
		}
		document.getElementById("tags").innerHTML = tag_html;
	}
}

function show_reply_panel(id){
	$("#"+"reply"+id).slideToggle("slow");
	var xmlHttp = new XMLHttpRequest();
	var send_string = "blog_id=" + id;
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
			  var xmlstr = xmlHttp.responseText;
			  var xmlDoc;  
			  try{ 
				  xmlDoc = new ActiveXObject("Microsoft.XMLDOM"); 
				  xmlDoc.loadXML(xmlstr); 
			     } 
			   catch(e){ 
				  var oParser=new DOMParser(); 
				  xmlDoc=oParser.parseFromString(xmlstr,"text/xml"); 
			  } 
			  if(xmlDoc!=null){
				 var reply_list = xmlDoc.getElementsByTagName("reply");
				 var replyhtml = "";
				 for(var i=0;i<reply_list.length;i++){
					 var appendstr = "";
					 appendstr = appendstr + "<p><span><a class='a6' href=\""+reply_list[i].childNodes[3].firstChild.data+"\">"+reply_list[i].childNodes[0].firstChild.data + "</a> reply <a class='a6' href=\"" 
					 +reply_list[i].childNodes[4].firstChild.data+"\">" + reply_list[i].childNodes[1].firstChild.data +"</a>:"+ reply_list[i].childNodes[2].firstChild.data+"</span></p>";
					 replyhtml = replyhtml + appendstr;
				 }
				 document.getElementById("reply_list"+id).innerHTML = replyhtml;
			 }
		}
	}
	send_string = "../blog/get_all_reply?" + send_string;
	xmlHttp.open("get", send_string);
	xmlHttp.send();
}

function add_reply(blog_id, user_id){
	var content = document.getElementById("new_reply_content"+blog_id).value;
	var to_id = document.getElementById("new_reply_to"+blog_id).innerText;
	var xhr = new XMLHttpRequest();
	var send_string="blog_id=" + blog_id + "&from="+ user_id + "&to=" + to_id +　"&content=" + content;
	xhr.onreadystatechange = function(){ 
		if(xhr.readyState==4 && xhr.status == 200){
			var result = xhr.responseText;
			var pre = document.getElementById("reply_list"+blog_id).innerHTML;
			document.getElementById("reply_list"+blog_id).innerHTML = result + pre;
			document.getElementById("new_reply_content"+blog_id).value="";
			var heat = document.getElementById("intheat"+blog_id).innerText;
			var reply = document.getElementById("intreply"+blog_id).innerText;
			var intheat = parseInt(heat);
			intheat++;
			var intreply = parseInt(reply);
			intreply++;
			document.getElementById("intheat"+blog_id).innerText = intheat;
			document.getElementById("intreply"+blog_id).innerText = intreply;
		}
	}
	var send_string = "../blog/add_reply?" + send_string;
	xhr.open("get", send_string);
	xhr.send();
}

function love(blog_id){
	$("#"+"love_list"+blog_id).slideToggle("slow");
	var xmlHttp = new XMLHttpRequest();
	var send_string="blog_id="+ blog_id;
	var current_relation = document.getElementById("love"+blog_id).innerText;
	xmlHttp.onreadystatechange = function(){ 
		if(xmlHttp.readyState==4 && xmlHttp.status == 200){
			var xmlstr = xmlHttp.responseText;
			  var xmlDoc;  
			  try{ 
				  xmlDoc = new ActiveXObject("Microsoft.XMLDOM"); 
				  xmlDoc.loadXML(xmlstr); 
			     } 
			   catch(e){ 
				  var oParser=new DOMParser(); 
				  xmlDoc=oParser.parseFromString(xmlstr,"text/xml"); 
			  } 
			  if(xmlDoc!=null){
				 var love_list = xmlDoc.getElementsByTagName("love");
				 
				 var lovehtml = document.getElementById("love_list"+blog_id).innerHTML;
				 for(var i=0;i<love_list.length;i++){
					 var appendstr = "";
					 appendstr = appendstr + "<p><span><a class='a6' href=\""+love_list[i].childNodes[1].firstChild.data+"\">"+love_list[i].childNodes[0].firstChild.data + "</a> love the blog very much!</span></p>";
					 lovehtml = lovehtml + appendstr;
				 }
				 document.getElementById("love_list"+blog_id).innerHTML = lovehtml;
				 var addheat = xmlDoc.getElementsByTagName("addheat");
				 for(var j=0;j<addheat.length;j++){
					 if(addheat[j].firstChild.data=="add"){
						 var heat = document.getElementById("intheat"+blog_id).innerText;
						 var intheat = parseInt(heat);
						 intheat++;
						 document.getElementById("intheat"+blog_id).innerText = intheat;
					 }
				 }
			 }
		}
	}
	var send_string = "../blog/love_blog?"+ send_string;
	xmlHttp.open("get", send_string);
	xmlHttp.send();
}

function show_publisher(){
	if(document.getElementById("publisher").innerText==""){
		document.getElementById("publisher").innerHTML = "<a class='a2' href='http://localhost/MomoMicroblog/index.php/momo/blog/new_article_blog'>Publish</a>";
	}
	document.getElementById("publisher").style.display = "block";
	$("#publisher").animate({height:70},1500);
}

function hide_publisher(){
	$("#publisher").animate({height:0},1500);
	document.getElementById("publisher").innerHTML = "<a class='a2' href='http://localhost/MomoMicroblog/index.php/momo/blog/new_article_blog'></a>";
}

function stop_animate(){
	if(document.getElementById("publisher").innerText==""){
		document.getElementById("publisher").innerHTML = "<a class='a2' href='http://localhost/MomoMicroblog/index.php/momo/blog/new_article_blog'>Publish</a>";
	}
	$("#publisher").stop();
}
function start_animate(){
    document.getElementById("publisher").innerHTML = "<a class='a2' href='http://localhost/MomoMicroblog/index.php/momo/blog/new_article_blog'>Publish</a>";
	$("#publisher").animate({height:0},1500);
}


function show_cancle(id){
	$("#"+id).fadeIn(100);
}
function hide_cancle(id){
	$("#"+id).fadeOut(1500);
}

function checkBlog(){
	
}