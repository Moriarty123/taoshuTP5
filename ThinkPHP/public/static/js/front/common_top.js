
//搜索
function checkSearch(){
	var keyword = document.getElementsByName("keyword")[0].value;
	var search = document.getElementsByClassName("search")[0];
	if(keyword == "" || keyword.length == 0 || keyword == null){
		search.style.borderColor = "#e71304";
		return false;
	}
	return true;
}
