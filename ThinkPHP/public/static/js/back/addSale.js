function Isbn(){
	var isbn = document.getElementsByName("isbn")[0];
	isbn.style.border = "1px solid #a9a9a9";
}
function checkISBN(){
	var isbn = document.getElementsByName("isbn")[0];
	if(isbn.value.length == 10 || isbn.value.length == 13){
		isbn.style.border = "1px solid #a9a9a9";
		return true;
	}
	else{
		isbn.style.border = "1px solid #e71304";
		return false;
	}
}


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


function Author(){
	var author = document.getElementsByName("author")[0];
	author.style.border = "1px solid #a9a9a9";
}
function checkAuthor(){
	var author = document.getElementsByName("author")[0];
	if(author.value.length > 0){
		author.style.border = "1px solid #a9a9a9";
		return true;
	}
	else{
		author.style.border = "1px solid #e71304";
		return false;
	}
}


function Publishing(){
	var publishing = document.getElementsByName("publishing")[0];
	publishing.style.border = "1px solid #a9a9a9";
}
function checkPublishing(){
	var publishing = document.getElementsByName("publishing")[0];
	if(publishing.value.length > 0){
		publishing.style.border = "1px solid #a9a9a9";
		return true;
	}
	else{
		publishing.style.border = "1px solid #e71304";
		return false;
	}
}


function Beprice(){
	var beprice = document.getElementsByName("beprice")[0];
	beprice.style.border = "1px solid #a9a9a9";
}
function checkBeprice(){
	var beprice = document.getElementsByName("beprice")[0];
	if(beprice.value.length == 0 || !beprice.value.match(/^[0-9]\d*(\.\d+)?$/) ){
		beprice.style.border = "1px solid #e71304";
		return false;
	}
	else{
		beprice.style.border = "1px solid #a9a9a9";
		return true;
	}
}


function Afprice(){
	var afprice = document.getElementsByName("afprice")[0];
	afprice.style.border = "1px solid #a9a9a9";
}
function checkAfprice(){
	var afprice = document.getElementsByName("afprice")[0];
	if(afprice.value.length == 0 || !afprice.value.match(/^[0-9]\d*(\.\d+)?$/) ){
		afprice.style.border = "1px solid #e71304";
		return false;
	}
	else{
		afprice.style.border = "1px solid #a9a9a9";
		return true;
	}
}


function Num(){
	var num = document.getElementsByName("num")[0];
	num.style.border = "1px solid #a9a9a9";
}
function checkNum(){
	var num = document.getElementsByName("num")[0];
	if(num.value.length == 0 || !num.value.match(/^[1-9]\d*(\.\d+)?$/) ){
		num.style.border = "1px solid #e71304";
		return false;
	}
	else{
		num.style.border = "1px solid #a9a9a9";
		return true;
	}
}


function Page(){
	var page = document.getElementsByName("page")[0];
	page.style.border = "1px solid #a9a9a9";
}
function checkPage(){
	var page = document.getElementsByName("page")[0];
	if(page.value.length == 0 || !page.value.match(/^[1-9]\d*(\.\d+)?$/) ){
		page.style.border = "1px solid #e71304";
		return false;
	}
	else{
		page.style.border = "1px solid #a9a9a9";
		return true;
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
		return true;
	}
	else{
		content.style.border = "1px solid #e71304";
		return false;
	}
}

function checkSale(){
	if(checkISBN()==true && checkName()==true && checkAuthor()==true && checkPublishing()==true && checkBeprice()==true && checkAfprice()==true && checkNum()==true && checkPage()==true){
		return true;
	}
	return false;
}

function checkComment(){
	if(checkContent()==true){
		return true;
	}
	return false;
}
