var prePwd_msg = document.getElementById("prePwd");
var newPwd_msg = document.getElementById("newPwd");
var rePwd_msg = document.getElementById("rePwd");

function Pre(){
	prePwd_msg.style.color = "#555";
	prePwd_msg.innerHTML = "请输入原始密码";
}
function checkPre(){
	var prepwd = document.getElementsByName("prepwd")[0].value;
	if(prepwd.length == 0){
		prePwd_msg.style.color = "#e71304";
		prePwd_msg.innerHTML = "<i class='fa fa-times-circle'></i>原始密码不能为空";
		return false;
	}
	else{
		prePwd_msg.style.color = "#00C7B4";
		prePwd_msg.innerHTML = "<i class='fa fa-check-circle'></i>";
		return true;
	}
}

function New(){
	newPwd_msg.style.color = "#555";
	newPwd_msg.innerHTML = "请输入新密码";
}
function checkNew(){
	var newPwd = document.getElementsByName("newPwd")[0].value;
	newPwd_msg.style.color = "#e71304";
	if(newPwd.length == 0){
		newPwd_msg.innerHTML = "<i class='fa fa-times-circle'></i>新密码不能为空";
	}
	else if(newPwd.length < 6 || newPwd.length > 16 ){
		newPwd_msg.innerHTML = "<i class='fa fa-times-circle'></i>密码长度需在6-16之间";
	}
	else if( newPwd.match( /(?!^\d+$)(?!^[A-Za-z]+$)(?!^_+$)^\w{6,16}$/ ) ){
		newPwd_msg.style.color="#00C7B4";
		newPwd_msg.innerHTML = "<i class='fa fa-check-circle'></i>";
		return true ;
	}
	else{
		newPwd_msg.innerHTML = "<i class='fa fa-times-circle'></i>密码必须是两种字符的组合";
	}
	return false ;     
}

function Re(){
	rePwd_msg.style.color = "#555";
	rePwd_msg.innerHTML="请再次输入新密码";
}
function checkRe(){
	var newPwd = document.getElementsByName("newPwd")[0].value;
	var rePwd = document.getElementsByName("rePwd")[0].value;
	
	if(newPwd != "" && rePwd != "" && newPwd == rePwd){
		rePwd_msg.innerHTML = "<i class='fa fa-check-circle'></i>";
		rePwd_msg.style.color = "#00C7B4";
		return true;
	}
	else if(rePwd.length == 0){
		rePwd_msg.innerHTML = "<i class='fa fa-times-circle'></i>重复密码不能为空";
		rePwd_msg.style.color = "#e71304";
		return false ;
	}
	else{
		rePwd_msg.innerHTML = "<i class='fa fa-times-circle'></i>密码不一致";
		rePwd_msg.style.color = "#e71304";
		return false ;
	}
}

// 验证全部
function checkAll(){
	if(checkPre() == true && checkNew() == true && checkRe() == true){
		return true;
	}
	return false;
}