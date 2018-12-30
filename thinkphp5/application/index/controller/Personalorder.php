<?php
namespace app\index\controller;
use \think\Controller;

class Personalorder extends \think\Controller
{
    
    public function index(){

       if(session('username')==NULL){
            $this->redirect('/index/login/index');
        }   
         return view('order_list');
    }
  //显示我的订单列表
 	public function alist(){
 		$sid = session('userid');

 		 $ret = db('user')->alias('a')->join('shoporder b',"a.user_id={$sid} and b.user_id={$sid} and b.order_buy=0")->join('sale_book c',"a.user_id={$sid} and b.user_id={$sid} and c.sale_id=b.book_id")->field('a.user_realname,b.*,c.*')->order('order_state','ASC')->select();
 		    
 		
       	 $this ->assign('ret',$ret);
       	 return view('order_list');
 	}
 	//确认收货
    public function shouhuo(){
	        $order_id = $_GET['order_id'];
	        $ret = db('shoporder')->where("order_id = {$order_id}")->find();
	        $ret['order_state']=1;
	       db('shoporder')->where("order_id = {$order_id}")->update($ret);
	       $this->redirect('/index/personalorder/alist');
    }
  //我的订单列表删除操作
    public function delete(){
      $sid = $_GET['id'];

      $ret = db('shoporder')->where("order_id={$sid}")->find();
      $ret['order_buy']=1;
      db('shoporder')->where("order_id={$sid}")->update($ret);
      $this->redirect('/index/personalorder/alist');
    }

 }