var asb_lists = document.getElementsByClassName("asb_list");
var alarms = document.getElementsByClassName("alarm");

// 书名检验
function Isbn(){
	asb_lists[0].style.borderColor = "#ddd";
}
function checkIsbn(){
	var isbn = document.getElementsByName("isbn")[0].value;
	if(isbn.length == 10 || isbn.length == 13){
		alarms[0].innerHTML = "<i class='fa fa-check-circle'></i>";
		return true;
	}
	alarms[0].innerHTML = "";
	asb_lists[0].style.borderColor = "#e71304";
	return false;
}

// 书名检验
function Name(){
	asb_lists[1].style.borderColor = "#ddd";
}
function checkName(){
	var bookname = document.getElementsByName("name")[0].value;
	if(bookname.length == 0){
		alarms[1].innerHTML = "";
		asb_lists[1].style.borderColor = "#e71304";
		return false;
	}
	alarms[1].innerHTML = "<i class='fa fa-check-circle'></i>";
	return true;
}

// 作者检验
function Author(){
	asb_lists[2].style.borderColor = "#ddd";
}
function checkAuthor(){
	var author = document.getElementsByName("author")[0].value;
	if(author.length == 0){
		alarms[2].innerHTML = "";
		asb_lists[2].style.borderColor = "#e71304";
		return false;
	}
	alarms[2].innerHTML = "<i class='fa fa-check-circle'></i>";
	return true;
}

// 出版社检验
function Publishing(){
	asb_lists[3].style.borderColor = "#ddd";
}
function checkPublishing(){
	var publishing = document.getElementsByName("publishing")[0].value;
	if(publishing.length == 0){
		alarms[3].innerHTML = "";
		asb_lists[3].style.borderColor = "#e71304";
		return false;
	}
	alarms[3].innerHTML = "<i class='fa fa-check-circle'></i>";
	return true;
}

// 原价检验  大于等于0的数字
function Beprice(){
	asb_lists[4].style.borderColor = "#ddd";
}
function checkBeprice(){
	var beprice = document.getElementsByName("beprice")[0].value;
	if(beprice.length == 0 || !beprice.match(/^[0-9]\d*(\.\d+)?$/) ){
		asb_lists[4].style.borderColor = "#e71304";
		alarms[4].innerHTML = "";
		return false;
	}
	alarms[4].innerHTML = "<i class='fa fa-check-circle'></i>";
	return true;
}

// 售价检验  大于等于0的数字
function Afprice(){
	asb_lists[5].style.borderColor = "#ddd";
}
function checkAfprice(){
	var afprice = document.getElementsByName("afprice")[0].value;
	if(afprice.length == 0 || !afprice.match(/^[0-9]\d*(\.\d+)?$/) ){
		asb_lists[5].style.borderColor = "#e71304";
		alarms[5].innerHTML = "";
		return false;
	}
	alarms[5].innerHTML = "<i class='fa fa-check-circle'></i>";
	return true;
}

// 库存量检验  大于0的数字
function Num(){
	asb_lists[6].style.borderColor = "#ddd";
}
function checkNum(){
	var num = document.getElementsByName("num")[0].value;
	if(num.length == 0 || !num.match(/^[1-9]\d*(\.\d+)?$/) ){
		asb_lists[6].style.borderColor = "#e71304";
		alarms[6].innerHTML = "";
		return false;
	}
	alarms[6].innerHTML = "<i class='fa fa-check-circle'></i>";
	return true;
}

// 页码检验  大于0的数字
function Page(){
	asb_lists[7].style.borderColor = "#ddd";
}
function checkPage(){
	var page = document.getElementsByName("page")[0].value;
	if(page.length == 0 || !page.match(/^[1-9]\d*(\.\d+)?$/) ){
		asb_lists[7].style.borderColor = "#e71304";
		alarms[7].innerHTML = "";
		return false;
	}
	alarms[7].innerHTML = "<i class='fa fa-check-circle'></i>";
	return true;
}

// 新旧程度检验
function Degrees(){
	asb_lists[8].style.borderColor = "#ddd";
}
function checkDegrees(){
	var degrees = document.getElementsByName("degrees")[0];
	if(degrees.selectedIndex == 0 ){
		asb_lists[8].style.borderColor = "#e71304";
		alarms[8].innerHTML = "";
		return false;
	}
	alarms[8].innerHTML = "<i class='fa fa-check-circle'></i>";
	return true;
}

// 类别检验
function Type(){
	asb_lists[9].style.borderColor = "#ddd";
}
function checkType(){
	var type = document.getElementsByName("type")[0];
	if(type.selectedIndex == 0 ){
		asb_lists[9].style.borderColor = "#e71304";
		alarms[9].innerHTML = "";
		return false;
	}
	alarms[9].innerHTML = "<i class='fa fa-check-circle'></i>";
	return true;
}


function checkAttach(){
	var attach = document.getElementsByName("attach")[0].value;
	if( attach.length > 255){
		asb_lists[11].style.borderColor = "#e71304";
		return false;
	}
	asb_lists[11].style.borderColor = "#ddd";
//	attach.replace(/\n|\r\n/g,"<br>");
	return true;
}

document.getElementsByName("content")[0].value.replace(/\n|\r\n/g,"<br>");

// 检验全部
function checkAll(){
	if( checkIsbn() == true && checkName() == true && checkAuthor() == true && checkPublishing() == true && checkBeprice() == true && checkAfprice() == true && checkNum() == true && checkPage() == true && checkDegrees() == true && checkType() == true ){
		if( confirm("你确定要发布该书籍吗？确认后不可更改") ){
			return true;
		}
		return false;
	}
	else{
		return false;
	}
}

function checkAll1(){
	if( checkIsbn() == true && checkName() == true && checkAuthor() == true && checkPublishing() == true && checkBeprice() == true && checkAfprice() == true && checkNum() == true && checkPage() == true && checkDegrees() == true && checkType() == true && checkAttach() == true){
		if( confirm("你确定要发布该书籍吗？确认后不可更改") ){
			return true;
		}
		return false;
	}
	else{
		return false;
	}
}