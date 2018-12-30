$(function(){

});
$(document).ready(function(){

//轮播图
  var img=$(".img_box img");
  var li=$(".ul5 li");
  var divW=$(".img_box").width();
  var len=$(".img_box img").length;
  img.css("left",divW);
  img.eq(0).css("left",0);
  li.eq(0).css("background","#00C7B4");
  var index=0;
  var next=0;
  function show(){
   next++;
   if(next==len){
    next=0;
   }
   img.eq(next).css("left",divW);
   img.eq(index).animate({"left":-divW});
   img.eq(next).animate({"left":0});
   li.eq(next).css("background","#00C7B4");
   li.eq(index).css("background","#f0f0f0");
   index=next;
  }
  t=setInterval(show,2000);
  function show1(){
   next--;
   if(next==-1){
    next=len-1;
   }
   img.eq(next).css("left",-divW);
   img.eq(index).animate({"left":divW});
   img.eq(next).animate({"left":0});
   li.eq(next).css("background","#00C7B4");
   li.eq(index).css("background","#f0f0f0");
   index=next;     
  }
  img.hover(function(){
   clearInterval(t);     
  },function(){
   t=setInterval(show,2000);
  })
  //左右按钮
  $(".d2").mousedown(function(){
   clearInterval(t);
   show();
  })
  $(".d2").mousedown(function(){
     t=setInterval(show,2000);
  }) 
  $(".d1").mousedown(function(){
   clearInterval(t);
     show1();
  })
  $(".d1").mousedown(function(){
   t=setInterval(show,2000);
  })
  //小白点 点击
  li.mousedown(function(){
   num=$(this).index();
   if(num==next){
    return;
   }else if(num<next){
    clearInterval(t);
    img.eq(num).css("left",-divW);
     img.eq(index).animate({"left":divW});
     img.eq(num).animate({"left":0});
     li.eq(num).css("background","#00C7B4");
     li.eq(index).css("background","#f0f0f0");
     index=num;
     next=num;
   }
   else if(num>next){
    clearInterval(t);
     img.eq(num).css("left",divW);
     img.eq(index).animate({"left":-divW});
     img.eq(num).animate({"left":0});
     li.eq(num).css("background","#00C7B4");
     li.eq(index).css("background","#f0f0f0");
     index=num;
     next=num;
   }
 })
    li.mouseup(function(){
     t=setInterval(show,2000);
   })
  })