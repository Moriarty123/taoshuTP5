<?php
namespace app\index\controller;
use \think\Controller;

class Orderreceive extends \think\Controller
{	
	//我收到的订单列表
    public function alist()
    {
    	$sid = session('userid');
    	 $ret = db('user')->alias('a')
		    	 ->join('shoporder b',"a.user_id={$sid}")
		    	 ->join('sale_book c',"c.sale_id=b.book_id and a.user_id=c.user_id")
		    	 ->field('a.user_realname,b.*,c.*')->paginate(5);
    	 
 		 $data=$ret->all();
       	 $this ->assign('ret',$data);
        return view('receive');
    }
 }