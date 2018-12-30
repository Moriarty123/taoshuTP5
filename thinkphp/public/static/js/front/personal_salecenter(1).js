var head_txts = document.getElementsByClassName("sc_right_head")[0].getElementsByTagName("span");
var contents = document.getElementsByClassName("sc_right_content");
for(var i = 0; i < head_txts.length; i++){
	head_txts[i].index = i;
	
	head_txts[i].onclick = function(){
		for(var j = 0; j < head_txts.length; j++){
			head_txts[j].removeAttribute("id");
			contents[j].style.display = "none";
		}
		this.setAttribute("id", "active");
		contents[this.index].style.display = "block";
		
	}
}
