function checkSearch(){
	var searchform = document.getElementsByClassName("searchform")[0];
	var search = document.getElementsByName("search")[0].value;
	if(search.length == 0){
		searchform.style.borderColor = "rgb(231, 19, 4)";
		return false;
	}
	else{
		searchform.style.borderColor = "#bbb";
		return true;
	}
}

