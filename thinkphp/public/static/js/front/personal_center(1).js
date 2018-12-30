//基本信息选项卡
var menu_head = document.getElementsByClassName("menu_head")[0];
var menu_head_lis = menu_head.getElementsByTagName("li");
var menu_details = document.getElementsByClassName("menu_detail");

for(var i = 0; i < menu_head_lis.length; i++){
	menu_head_lis[i].index = i;
	
	menu_head_lis[i].onclick = function(){
		for(var j = 0; j < menu_head_lis.length; j++){
			menu_head_lis[j].removeAttribute("id");
			menu_details[j].style.display = "none";
		}
		this.setAttribute("id", "active");
		menu_details[this.index].style.display = "block";
		
	}
}

// 提示昵称
var nick_msg = document.getElementById("nick_msg");
function nickName(){
	nick_msg.style.color = "#555";
	nick_msg.innerHTML = "请输入昵称";
}
function checkNick(){
	nick_msg.innerHTML = "";
}

//验证真实姓名
var real_msg = document.getElementById("real_msg");
function realName(){
	real_msg.style.color = "#555";
	real_msg.innerHTML = "请输入真实姓名";
}
function checkReal(){
	var realname = document.getElementsByName("realname")[0].value;
	real_msg.style.color = "#e71304";
	if(realname.length == 0){
		real_msg.innerHTML = "<i class='fa fa-times-circle'></i>真实姓名不能为空";
		return false;
	}
	else if(realname.length < 2 || realname.length > 16 ){
		real_msg.innerHTML = "<i class='fa fa-times-circle'></i>真实姓名需在2-16之间";
		return false;
	}
	else{
		real_msg.style.color = "#00C7B4";
		real_msg.innerHTML = "<i class='fa fa-check-circle'></i>";
		return true;
	}
}

// 验证班别
var grade_msg = document.getElementById("grade_msg");
function checkGrade(){
	var grade = document.getElementsByName("grade")[0];
	var uclass = document.getElementsByName("class")[0];
	if( grade.selectedIndex == 0 ){
		grade_msg.style.color = "#e71304";
		grade_msg.innerHTML = "<i class='fa fa-times-circle'></i>请选择年级";
		return false;
	}
	if( uclass.selectedIndex == 0 ){
		grade_msg.style.color = "#e71304";
		grade_msg.innerHTML = "<i class='fa fa-times-circle'></i>请选择专业";
		return false;
	}
	return true;
}

// 验证地址
var addr_msg = document.getElementById("addr_msg");
function Addr(){
	addr_msg.style.color = "#555";
	addr_msg.innerHTML = "请输入地址";
}
function checkAddr(){
	var addr = document.getElementsByName("addr")[0].value;
	if(addr.length == 0){
		addr_msg.style.color = "#e71304";
		addr_msg.innerHTML = "<i class='fa fa-times-circle'></i>地址不能为空";
		return false;
	}
	else if( addr.length > 100 ){
		addr_msg.style.color = "#e71304";
		addr_msg.innerHTML = "<i class='fa fa-times-circle'></i>长度应小于100字符";
		return false;
	}
	else{
		addr_msg.style.color = "#00C7B4";
		addr_msg.innerHTML = "<i class='fa fa-check-circle'></i>";
		return true;
	}
}

// 验证联系方式
var tel_msg = document.getElementById("tel_msg");
function Tel(){
	tel_msg.style.color = "#555";
	tel_msg.innerHTML = "请输入联系方式";
}
function checkTel(){
	var tel = document.getElementsByName("tel")[0].value;
	if(tel.length == 0){
		tel_msg.style.color = "#e71304";
		tel_msg.innerHTML = "<i class='fa fa-times-circle'></i>联系方式不能为空";
		return false;
	}
	else if( tel.match( /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/ ) ){
		tel_msg.style.color = "#00C7B4";
		tel_msg.innerHTML = "<i class='fa fa-check-circle'></i>";
		return true;
	}
	else{
		tel_msg.style.color = "#e71304";
		tel_msg.innerHTML = "<i class='fa fa-times-circle'></i>请正确输入联系方式";
		return false;
	}
}

// 验证个人说明
var content_msg = document.getElementById("content_msg");
function Content(){
	content_msg.style.color = "#555";
	content_msg.innerHTML = "请输入个性签名";
}
function checkContent(){
	content_msg.innerHTML = "";
	var content = document.getElementsByName("content")[0].value;
	if(content.length > 200){
		content_msg.innerHTML = "个人签名应少于200字";
		content_msg.style.color = "#e71304";
		return false;
	}
	else{
		return true;
	}
}

// 验证全部
function checkAll(){
	if(checkReal() == true && checkGrade() == true && checkAddr() == true && checkTel() == true && checkContent() == true ){
		return true;
	}
	return false;
}


function preview1(file) {
    var img = new Image(), url = img.src = URL.createObjectURL(file);
    var $img = $(img);
    img.onload = function() {
    	URL.revokeObjectURL(url);
   		$('#preview').empty().append($img);
  	}
}
function preview2(file) {
    var reader = new FileReader();
    reader.onload = function(e) {
    	var $img = $('<img>').attr("src", e.target.result);
    	$('#preview').empty().append($img);
    }
    reader.readAsDataURL(file);
}
$(function() {
    $('[type=file]').change(function(e) {
        var file = e.target.files[0];
        preview1(file);
    })
})