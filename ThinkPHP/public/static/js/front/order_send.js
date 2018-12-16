//var setMsg = document.getElementById("setMsg");
//setMsg.onclick = function(){
////	alert("aa");
//	document.getElementsByTagName("body")[0].style.background = "rgba(0,0,0, 0.5)"
//	var setMsg_div = document.getElementsByClassName("setMsg_div")[0];
//	setMsg_div.style.display = "block";
//}

var send = document.getElementsByClassName("send")[0];
var os_msg_content = document.getElementsByClassName("os_msg_content");
send.onclick = function(){
	if( os_msg_content[0].style.display == "block" ){
		alert("请先设置收货人信息");
		return false;
	}
	else{
		if( confirm("你确认要提交此订单吗？") ){
			if( confirm("提交后不可更改！") ){
				return true;
			}
			return false;
		}
		else{
			return false;
		}
	}
}
