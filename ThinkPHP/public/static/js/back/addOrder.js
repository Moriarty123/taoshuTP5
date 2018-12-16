function ShowNum(){
	var num = document.getElementsByClassName("num")[0];
	var name_value = document.getElementsByName("name")[0].value;	//选择哪个 书籍 下拉选项
	
	var price_span_value = "price_span"+name_value;
	var price_span_display = num.getElementsByClassName(price_span_value)[0]; //单价
	
	var num_span_value = "num_span"+name_value;
	var num_span_display = num.getElementsByClassName(num_span_value)[0];	// 库存
	
	var num_span = num.getElementsByTagName("span");
	var num_option = document.getElementsByName("num")[0];
	var price = document.getElementsByName("price")[0];	//总金额的input框
	
	if(name_value == 0){
		num.style.display = "none";
		num_option.options.length = 1;
	}
	else{
		for(var i = 0; i < num_span.length; i++){
			num_span[i].style.display = "none";
		}
		var num_label = num_span_display.getElementsByTagName("label")[0].innerHTML;
		num_option.options.length = 1;	//每次加载书籍之前，先清空下拉选项
		for(var i = 1; i <= num_label; i++){
			var opt = document.createElement("option");
			opt.value = i;
			opt.innerHTML = i;
			num_option.appendChild(opt);
		}
		price_span_display.style.display = "block";
		num.style.display = "block";
		price.value = "";  
	}
}

function FloatMul(arg1, arg2){
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try{
    	m += s1.split(".")[1].length;
    } catch(e){ }
    try{
    	m += s2.split(".")[1].length;
    } catch(e){ }
    return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}

function ShowPrice(){
	var num = document.getElementsByClassName("num")[0];
	var name_value = document.getElementsByName("name")[0].value;	//选择哪个 书籍 下拉选项
	
	var price_span_value = "price_span"+name_value;
	var price_span_display = num.getElementsByClassName(price_span_value)[0]; //单价-span标签
	var price_label = price_span_display.getElementsByTagName("label")[0].innerHTML;  //单价- label 标签里的数字
	
	var num_value = document.getElementsByName("num")[0].value;	// 选择哪个 数量 的下拉选项
	var price = document.getElementsByName("price")[0];	//总金额的input框
	price.value = FloatMul(parseFloat(price_label) , parseInt(num_value) );
}

function checkName(){
	var name = document.getElementsByName("name")[0];
	if(name.selectedIndex == 0){
		name.style.border = "1px solid #e71304";
		return false;
	}
	else{
		name.style.border = "1px solid #a9a9a9";
		return true;
	}
}

function checkNum(){
	var num = document.getElementsByName("num")[0];
	if(num.selectedIndex == 0){
		num.style.border = "1px solid #e71304";
		return false;
	}
	else{
		num.style.border = "1px solid #a9a9a9";
		return true;
	}
}

function checkOrder(){
	if( checkName() == true && checkNum() == true){
		if(confirm("确认要提交订单吗？")){
			return true;
		}
		return false;
	}
	else{
		return false;
	}
}
