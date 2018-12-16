// obj:  input 全选按钮点击
function fullChecked(obj){
	var  bool=  obj.checked;	// 获取到  全选按钮 对应在选中还是联选中在状态:如果选中true,如果不选中  fasle
	// 获取 每一个商品前面在  复选框   Input这个元素
	var items = document.getElementsByClassName("eachChoose");
	// 需要遍历每一个 选框，并且将每一个复选框的checked 的值  跟全选 的checked
	for(var i = 0; i < items.length; i++){
		items[i].checked = bool;
	}
	// 获取 全选的按钮
	var fulls =  document.getElementsByName("fullChoose"); //全选也必须 和  bool一样 2
	for(var j = 0; j < fulls.length; j++){
		fulls[j].checked = bool;
	}
	getCheck();
	setBtnStyle();
}

// 选每个单元格的复选框
function eachChecked(){
	// 判断  ： 判断是不是所有复选框都被选中，如果有一个按钮没被选中，则全选按钮不选中
	var bool = true; // 默认 全选按钮 为true，即默认 被选中
	// 获取所有商品的input
	var items = document.getElementsByClassName("eachChoose");
	for(var i = 0; i < items.length; i++){
		if(items[i].checked == false){  // 只要有一个复选框没被选中，则全选按钮不选中，退出循环
			bool = false;
			break;  // 退出循环，没必要再继续循环，因为已经知道结果
		}
	}
	// 设置全选按钮的选中状态
	var fulls = document.getElementsByName("fullChoose");
	for(var j = 0; j < fulls.length; j++){
		fulls[j].checked = bool;
	}
	getCheck();
	setBtnStyle();
}

// 获取金额： 选中在总金额
function getCheck(){
	var total = 0;
	var items = document.getElementsByClassName("eachChoose");
	var notdisplay = document.getElementById("notdisplay");
	for(var j = 0; j < items.length; j++){
		if(items[j].checked == true){ // 一个一个去遍历， 如果有一个  checked==true
			var tr = items[j].parentElement.parentElement;
			var td1 = tr.cells[1].innerHTML;
			total += parseInt(td1);
		}
		notdisplay.innerHTML = total;
	}
}

function setBtnStyle(){
	var num = document.getElementById("notdisplay").innerHTML;
	var deleteCheck = document.getElementById("delBtn");
	var count = parseInt(num);
	if(count == 0) {  // 数量为0，加载sum样式
		deleteCheck.className="delBtn";
		deleteCheck.setAttribute("disabled",'disabled');
	}
	else{  // 数量不为0，加载newsum样式
		deleteCheck.className="newdelBtn";
		deleteCheck.removeAttribute("disabled");
	}
}
