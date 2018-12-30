// http://www.cnblogs.com/moxuanshang/p/5790466.html (摘取此网址)
//乘法函数，用来得到精确的乘法结果
//说明：javascript的乘法结果会有误差，在两个浮点数相乘的时候会比较明显。这个函数返回较为精确的乘法结果。
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

 //浮点数加法运算
function FloatAdd(arg1, arg2){
    var r1, r2, m;
    try {
    	r1=arg1.toString().split(".")[1].length;
    } catch(e){ r1=0; }
    try {
    	r2=arg2.toString().split(".")[1].length;
    } catch(e){ r2=0; }
    m = Math.pow(10, Math.max(r1,r2));
    return (arg1 * m + arg2 * m) / m;
}

// obj:参数指的是：  当前点击在按钮 对象
//function add(obj){
//	var td = obj.parentElement; 		// 获取button所在的父节点
//	var tr = td.parentElement;
//	var td6 = tr.cells[5].innerHTML;	// 获取库存量的值
//	var span = td.getElementsByTagName("span")[0];
//	var oldNum = parseInt(span.innerHTML); // 旧的数据，字符串转换为int
//	if(oldNum < td6){
//		var newNum = oldNum + 1;  		// 加1之后在数量
//		span.innerHTML = newNum;
//	}
//	else{
//		alert("库存量不足！");
//		span.innerHTML = oldNum;
//	}
//	// 计算金额  tableDom
//	var td5 = tr.cells[4].getElementsByTagName("span")[0]; //当前点击在 第5个单元格：单价所在的单元格： 下标从0开始
//	var td8 = tr.cells[7].getElementsByTagName("span")[0]; //当前点击在 第5个单元格：小计金额所在的单元格 
//	var price = parseFloat(td5.innerHTML); // innerHTML获取的是字符串，需转换为浮点型
//	var money = FloatMul(price, newNum);  // 运用上面的accMul方法可以精确计算金额	
//	td8.innerHTML = money;  // 将money值写入到第4个单元格中，即金额的单元格
//	writeNumMoney(getCount(), getMoney());
//}

// 点击减号按钮
//function sub(obj){
//	var span = obj.nextElementSibling; // 获取-按钮下一个兄弟
//	var oldNum = parseInt(span.innerHTML); // 旧数据
//	if(oldNum == 1){
//	    if(confirm("您确定要删除吗？")){
//	    	// 将当前这一条记录删除！  将一整行删除：table对象 -----行：
//	    	var tr = obj.parentElement.parentElement;// 
//	    	var table = document.getElementsByTagName("table")[0];
//	    	table.deleteRow(tr.rowIndex);//tr.rowIndex:tr所在在行de索引
//	    	return;
//	    }
//	}
//	else{ // 数量>1
//		var newNum = oldNum - 1;
//	  	span.innerHTML = newNum;	// 需要将num写入到 span中去
//	  	// 1、还需要获取单价
//	  	var  tr = obj.parentElement.parentElement;
//	  	var price = parseFloat(tr.cells[4].getElementsByTagName("span")[0].innerHTML);
//	  	
//	  	var money = FloatMul(price, newNum);  // 运用上面的accMul方法可以精确计算金额
//	  	// 获取金额所在在单元格
//	  	tr.cells[7].getElementsByTagName("span")[0].innerHTML = money;	
//	}
//	writeNumMoney(getCount(), getMoney());
//	setBtnStyle();
//}



// 根据复选框的选中状态来删除商品
function deleteChecked(){   
  	var table = document.getElementsByTagName("table")[0]; // 获取table
  	var inputs = table.getElementsByTagName("input"); // 获取table2里面的input标签
	if(confirm("是否将选中的商品删除？")){
		for(var i = 0; i < inputs.length; i++){
	  		if(inputs[i].checked == true){
	  			var tr = inputs[i].parentElement.parentElement;  // 获取复选框所在的那一行    即tr
	  			table.deleteRow(tr.rowIndex);
	  			i--;
	  		}
	  	}
	}
	writeNumMoney(getCount(), getMoney());
	setBtnStyle();
}

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
	writeNumMoney(getCount(), getMoney());
	// 改变按钮的样式
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
	writeNumMoney(getCount(), getMoney());
	// 改变按钮的样式
	setBtnStyle();
}


// 获取数量：选中的数量
function getCount(){
	// 获取每一个商品  
	var totalNum = 0; // 累加数量
	var  items = document.getElementsByClassName("eachChoose");
	for(var i = 0; i < items.length; i++){
		if(items[i].checked == true){ // 一个一个去遍历， 如果有一个  checked==true
			// 获取数量
			var tr = items[i].parentElement.parentElement;
			var td7 = tr.cells[6];
			var strnum = td7.getElementsByTagName("span")[0].innerHTML;
		    var num = parseInt(strnum);
			totalNum += num; // 累加，在这里直接用 += 比较简单，因为是int加法
		}
	}
	return totalNum;
}

// 获取金额： 选中在总金额
function getMoney(){
	var totalMoney = 0;
	var items = document.getElementsByClassName("eachChoose");
	for(var j = 0; j < items.length; j++){
		if(items[j].checked == true){ // 一个一个去遍历， 如果有一个  checked==true
			// 获取数量
			var tr = items[j].parentElement.parentElement;
			var td8 = tr.cells[7].getElementsByTagName("span")[0];
		    var money = parseFloat(td8.innerHTML); // 获取金额单元格的数字（字符串），并转换为float型
			totalMoney = FloatAdd(totalMoney, money); // 在这里用上面的float加法计算比较精确
		}
	}
	return '￥'+totalMoney;
}

// 当获取到的数量和金额写入到对应的计算数量和金额的位置
function writeNumMoney(totalNum, totalMoney){
	document.getElementsByClassName("num")[0].innerHTML = totalNum;
	document.getElementsByClassName("money")[0].innerHTML = totalMoney;
}


// 用来设置button的样式，两套样式          sum 和    newnum
function setBtnStyle(){
	// 取决于前面的共选商品的数量，如果为零，则按钮显示灰色，样式为sum,  如果数量不为0，则用newsum样式
	var num = document.getElementsByClassName("num")[0].innerHTML;
	var count = parseInt(num);
	// 获取结算按钮
	var sumBtn = document.getElementById("sumBtn");
	var deleteCheck = document.getElementById("delBtn");
	if(count == 0) {  // 数量为0，加载sum样式
		sumBtn.className="sum";
		deleteCheck.className="deleteChecked";
		
		// 添加禁用按钮，即添加disable属性
		sumBtn.setAttribute("disabled",'disabled');
		deleteCheck.setAttribute("disabled",'disabled');
	}
	else{  // 数量不为0，加载newsum样式
		sumBtn.className = "newnum";
		deleteCheck.className="newdeleteChecked";
		
		// 去掉禁用按钮，即去掉disable属性
		sumBtn.removeAttribute("disabled");
		deleteCheck.removeAttribute("disabled");
	}
}
