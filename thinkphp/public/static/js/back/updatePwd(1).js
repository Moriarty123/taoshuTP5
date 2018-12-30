function Pre(){
	var pre = document.getElementsByName("prepwd")[0];
	pre.style.border = "1px solid #a9a9a9";
}

function checkPre(){
	var pre = document.getElementsByName("prepwd")[0];
	if(pre.value.length > 0){
		pre.style.border = "1px solid #a9a9a9";
		return true;
	}
	else{
		pre.style.border = "1px solid #e71304";
		return false;
	}
}

function Pwd(){
	var pwd = document.getElementsByName("pwd")[0];
	pwd.style.border = "1px solid #a9a9a9";
}

function checkPwd(){
	var pwd = document.getElementsByName("pwd")[0];
	if(pwd.value.length > 0){
		pwd.style.border = "1px solid #a9a9a9";
		return true;
	}
	else{
		pwd.style.border = "1px solid #e71304";
		return false;
	}
}

function Repwd(){
	var repwd = document.getElementsByName("repwd")[0];
	repwd.style.border = "1px solid #a9a9a9";
}

function checkRepwd(){
	var repwd = document.getElementsByName("repwd")[0];
	var newpwd = document.getElementsByName("pwd")[0].value;
	if(newpwd != "" && repwd.value != "" && newpwd == repwd.value){
		repwd.style.border = "1px solid #a9a9a9";
		return true;
	}
	else{
		repwd.style.border = "1px solid #e71304";
		return false ;
	}
}

//用户名
function Name(){
	var name = document.getElementsByName("name")[0];
	name.style.border = "1px solid #a9a9a9";
}
function checkName(){
	var name = document.getElementsByName("name")[0];
	if(name.value.length > 0){
		name.style.border = "1px solid #a9a9a9";
		return true;
	}
	else{
		name.style.border = "1px solid #e71304";
		return false;
	}
}


function checkAdmin(){
	if(checkPre() == true && checkPwd() == true && checkRepwd() == true){
		return true;
	}
	return false;
}

function checkUser(){
	if(checkPwd() == true && checkRepwd() == true){
		return true;
	}
	return false;
}

function checkAddAdmin(){
	if(checkName() == true && checkPwd() == true && checkRepwd() == true){
		return true;
	}
	return false;
}
