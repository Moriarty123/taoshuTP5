//基本信息选项卡
var type_lis = document.getElementsByClassName("type_li");
var type_divs = document.getElementsByClassName("type_div");

for(var i = 0; i < type_lis.length; i++){
	type_lis[i].index = i;
	
	type_lis[i].onmouseover = function(){
		for(var j = 0; j < type_lis.length; j++){
			type_lis[j].removeAttribute("id");
			type_divs[j].style.display = "none";
		}
		this.setAttribute("id", "active");
		type_divs[this.index].style.display = "block";
	}
	type_lis[i].onmouseout = function(){
		for(var j = 0; j < type_lis.length; j++){
			type_lis[j].removeAttribute("id");
			type_divs[j].style.display = "none";
		}
	}
}

for(var i = 0; i < type_divs.length; i++){
	type_divs[i].index = i;
	
	type_divs[i].onmouseover = function(){
		for(var j = 0; j < type_divs.length; j++){
			type_lis[j].removeAttribute("id");
			type_divs[j].style.display = "none";
		}
		type_lis[this.index].setAttribute("id", "active");
		this.style.display = "block";
	}
	
	type_divs[i].onmouseout = function(){
		for(var j = 0; j < type_divs.length; j++){
			type_lis[j].removeAttribute("id");
			type_divs[j].style.display = "none";
		}
	}
}
