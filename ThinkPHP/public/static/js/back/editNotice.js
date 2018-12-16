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

//用户名
function Content(){
	var content = document.getElementsByName("content")[0];
	content.style.border = "1px solid #a9a9a9";
}
function checkContent(){
	var content = document.getElementsByName("content")[0];
	if(content.value.length > 0){
		content.style.border = "1px solid #a9a9a9";
		return true;
	}
	else{
		content.style.border = "1px solid #e71304";
		return false;
	}
}

function checkEditNotice(){
	if(checkName() == true && checkContent() == true){
		return true;
	}
	return false;
}
