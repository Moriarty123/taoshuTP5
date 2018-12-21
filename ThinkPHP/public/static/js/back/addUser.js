//用户名
function Name(){
	var name = document.getElementsByName("name")[0];
	name.style.border = "1px solid #a9a9a9";

}
function checkName(){
	var name = document.getElementsByName("name")[0];
	if(name.value.length == 12){
		name.style.border = "1px solid #a9a9a9";
		document.getElementById('tip-name').style.display = 'none';
		return true;
	}
	else{
		name.style.border = "1px solid #e71304";
		console.log(document.getElementById('tip-name'));
		document.getElementById('tip-name').style.display = 'block';
		return false;
	}
}

//密码
function Pwd(){
	var pwd = document.getElementsByName("pwd")[0];
	pwd.style.border = "1px solid #a9a9a9";
}
function checkPwd(){
	var pwd = document.getElementsByName("pwd")[0];
	if( pwd.value.match( /(?!^\d+$)(?!^[A-Za-z]+$)(?!^_+$)^\w{6,16}$/ ) ){
		pwd.style.border = "1px solid #a9a9a9";
		document.getElementById('tip-pwd').style.display = 'none';
		return true;
	}
	else{
		pwd.style.border = "1px solid #e71304";
		document.getElementById('tip-pwd').style.display = 'block';
		return false;
	}
}

//真实姓名
function Real(){
	var real = document.getElementsByName("realname")[0];
	real.style.border = "1px solid #a9a9a9";
}
function checkReal(){
	var real = document.getElementsByName("realname")[0];
	if( real.value.length > 0 ){
		real.style.border = "1px solid #a9a9a9";
		document.getElementById('tip-realname').style.display = 'none';
		return true;
	}
	else{
		real.style.border = "1px solid #e71304";
		document.getElementById('tip-realname').style.display = 'block';
		return false;
	}
}

//联系方式
function Tel(){
	var tel = document.getElementsByName("tel")[0];
	tel.style.border = "1px solid #a9a9a9";
}
function checkTel(){
	var tel = document.getElementsByName("tel")[0];
	if( tel.value.match( /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/ ) ){
		tel.style.border = "1px solid #a9a9a9";
		document.getElementById('tip-tel').style.display = 'none';
		return true;
	}
	else{
		tel.style.border = "1px solid #e71304";
		document.getElementById('tip-tel').style.display = 'block';
		return false;
	}
}

//详细地址
function Addr(){
	var addr = document.getElementsByName("addr")[0];
	addr.style.border = "1px solid #a9a9a9";
}
function checkAddr(){
	var addr = document.getElementsByName("addr")[0];
	if( addr.value.length > 0 ){
		addr.style.border = "1px solid #a9a9a9";
		document.getElementById('tip-addr').style.display = 'none';
		return true;
	}
	else{
		addr.style.border = "1px solid #e71304";
		document.getElementById('tip-addr').style.display = 'block';
		return false;
	}
}

function checkAddUser(){
	if(checkName() == true && checkPwd() == true && checkReal() == true && checkTel() == true && checkAddr() == true ){
		return true;
	}
	return false;
}

function checkEdit(){
	if(checkReal() == true && checkTel() == true && checkAddr() == true ){
		return true;
	}
	return false;
}
