function Title(){
	var title = document.getElementsByName("title")[0];
	title.style.border = "1px solid #a9a9a9";
}

function checkTitle(){
	var title = document.getElementsByName("title")[0];
	if( title.value.length > 0 ){
		title.style.border = "1px solid #a9a9a9";
		document.getElementById('tip-title').style.display = 'none';
		return true;
	}
	else{
		title.style.border = "1px solid #e71304";
		document.getElementById('tip-title').style.display = 'block';
		return false;
	}
}

function Content(){
	var content = document.getElementsByName("content")[0];
	content.style.border = "1px solid #a9a9a9";
}
function checkContent(){
	var content = document.getElementsByName("content")[0];
	if(content.value.length > 0){
		content.style.border = "1px solid #a9a9a9";
		document.getElementById('tip-content').style.display = 'none';
		return true;
	}
	else{
		content.style.border = "1px solid #e71304";
		document.getElementById('tip-content').style.display = 'block';
		return false;
	}
}