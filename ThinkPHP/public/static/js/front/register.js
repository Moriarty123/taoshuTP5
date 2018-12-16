var usermsg= document.getElementById("usermsg");	// 用户名的提示框
var pwdmsg= document.getElementById("pwdmsg");		// 设置密码的提示框
var repwdmsg= document.getElementById("repwdmsg"); 	// 确认密码提示框

//用户名校验开始
function checkName(){
	var vinput= document.getElementsByName("username")[0];    /* 数组从0开始 */
	var username = vinput.value;  //input框中的值
	usermsg.style.color="#e71304";
	//对输入的值进行判断	         
	if(username.length==0){
	    usermsg.innerHTML="<i class='fa fa-times-circle'></i>用户名不能为空";
	}
	else if(username.length >=4 && username.length <=15 ){
	    usermsg.innerHTML="<i class='fa fa-check-circle'></i>";
	    usermsg.style.color="#00C7B4";
	    return true;
	}
	else{
		usermsg.innerHTML="<i class='fa fa-times-circle'></i>长度只能在4-15之间";
	}
	return false;         //记住，一旦执行了ruturn便结束方法，不会执行下面的代码；
}
//用户名提示
function alertName(){
	usermsg.innerHTML="<i class='fa fa-info-circle'></i>4-15个字符，支持字母，数字，中文等";
	usermsg.style.color="#00C7B4";
}

//校验密码开始
function checkPwd(){
	pwdmsg.style.color="#e71304";
			    
	var vpwd= document.getElementsByName("password")[0];    /* 数组从0开始 */
	var pwd = vpwd.value;  //input框中的值
		        
	//对输入的值进行判断
	var str="";      
	if(pwd.length == 0){
		str="<i class='fa fa-times-circle'></i>密码不能为空";
	}
	else if(pwd.length < 6 || pwd.length > 16 ){
		str="<i class='fa fa-times-circle'></i>密码长度需在6-16之间";
	}
	else if( pwd.match(/(?!^\d+$)(?!^[A-Za-z]+$)(?!^_+$)^\w{6,16}$/) ){
		str="<i class='fa fa-check-circle'></i>";
		pwdmsg.style.color="#00C7B4";
		pwdmsg.innerHTML=str;       //这里应写这个获取值,不然最后return之后写不进去str。
		return true ;
	}
	else{
		str="<i class='fa fa-times-circle'></i>密码必须是字母和数字两种字符的组合";
	}
	pwdmsg.innerHTML=str;
	return false ;     
}

// 密码提示
function alertPwd(){
	pwdmsg.innerHTML="<i class='fa fa-info-circle'></i>6-16个字符，必须是字母和数字两种字符的组合";
	pwdmsg.style.color="#00C7B4";
}

//确认密码开始
function checkRePwd(){
	var vpwd1 = document.getElementById("password");
	var password = vpwd1.value; 
	var vpwd2 = document.getElementById("repassword");
	var repassword = vpwd2.value; 
	if(password != "" && repassword != "" && password == repassword){
		repwdmsg.innerHTML = "<i class='fa fa-check-circle'></i>";
		repwdmsg.style.color = "#00C7B4";
		return true;
	}
	else{
		repwdmsg.innerHTML = "<i class='fa fa-times-circle'></i>密码不一致";
		repwdmsg.style.color = "#e71304";
		return false ;
	}
}

// 重复密码提示
function alertRePwd(){
	repwdmsg.innerHTML = "<i class='fa fa-info-circle'></i>请再次输入密码";
	repwdmsg.style.color = "#00C7B4";
}

//验证码
var code;//变成全局的
function createCode(){
	var length = 4;
	var codes = new Array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g',
	'h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x',
	'y','z','A','B','C','D','E','F','G','H','I','J','J','L','M','N','O',
	'P','Q','R','S','T','U','V','W','X','Y','Z');
		
	code = "";
	for(var i = 0; i < length; i++){
		//随机从数组中取出的Code
		var index = Math.floor(Math.random() * codes.length);  //产生[0,1)之间的数，数量在0~codes.length-1
		//把它变成整数，向下取整，因为codes.length-1，写成了codes.length
		code += codes[index];   //拼接起来
	}
	document.getElementById("codeImg").innerHTML = code;
}
		
function confirmCode(){
	//input中输入的验证码和生成的是否一样
	var vcode = document.getElementById("code").value;
	var codemsg = document.getElementById("codemsg");
		
	code = code.toLowerCase();    //大写变小写函数
	vcode = vcode.toLowerCase();   //大写变小写函数，去掉的话就不会大小写忽略
	if(vcode !== "" && vcode.length != 0 && vcode != null && vcode == code){
		codemsg.innerHTML = "<i class='fa fa-check-circle'></i>";
		codemsg.style.color = "#00C7B4";
		return true ;  
	}
	else{
		codemsg.innerHTML="<i class='fa fa-times-circle'></i>验证码有误";
		codemsg.style.color="#e71304";
//		createCode();  //错误重新生成
	}
	return false ;
}
window.onload=createCode;
// 验证码结束

//验证码提示框
function alertCode(){
	codemsg.innerHTML = "<i class='fa fa-info-circle'></i>不区分大小写";
	codemsg.style.color = "#00C7B4";
}

// 验证全部
function checkAll(){
	if(checkName() == true && checkPwd() == true &&  confirmCode() == true &&  checkRePwd() == true){
		return true;
	}
//	alert("请检查您的选项");
	return false;
}
