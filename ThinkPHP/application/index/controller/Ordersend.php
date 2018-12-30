<?php
namespace app\index\controller;
use \think\Controller;
use \think\Db;
class Ordersend extends \think\Controller
{
   //购买 订单页面
    public function index(){
        
     if(session('username')==NULL){
            $this->redirect('/index/login/index');
        }  

    		$sale_id = $_GET['id'];
    		$user_id = session('userid');
	    	$ret = db('user')->alias('a')->join('sale_book b',"a.user_id=b.user_id and b.sale_id={$sale_id}")->field('a.user_realname,b.*')->find();
            $res = db('user')->where("user_id={$user_id}")->find();
            $this->assign('res',$res); 

        if($user_id==$ret['user_id']){
             $this->error("对不起，不能购买您自己发布的书籍");
        }
        if($ret['sale_num']==0){
            $this->error("该书籍存量不足，您可以先将其加入购物车");
        }

	    	$this->assign('ret',$ret);
	    	
	    	return view('ordersend');
    }

    //直接购买提交订单
    public function submitorder(){   

    		//生成订单号
    		$order_id = date("Y-m-dH-i-s");
			$order_id = str_replace("-","",$order_id);
			$order_id .= session('userid');
			$order_id .= rand(1000,999999);

    		$sale_id = $_GET['id'];
    		$user_id =session('userid');
    		$creat_time = time();
    		$ret = db('sale_book')->where("sale_id={$sale_id}")->find();
    		$order_price = $ret['sale_afprice'];

    		$data=[
    				'order_id'=>$order_id,
    				'book_id'=>$sale_id,
    				'user_id'=>$user_id,
    				'create_time'=>$creat_time,
    				'order_price'=>$order_price,
    				'order_sum'=>1
    		];
    		$res = db('shoporder')->insert($data);
    		if($res == true){
    			  $ret['sale_num']=$ret['sale_num']-1;
                  // if ($ret['sale_num']==0) {
                  //       Db::query('SET FOREIGN_KEY_CHECKS = 0;');//暂时取消外键
                  //     db('sale_book')->where("sale_id={$sale_id}")->delete();
                  //     Db::query('SET FOREIGN_KEY_CHECKS = 1;');//重新设置外键
                  // }else{
                  db('sale_book')->where("sale_id={$sale_id}")->update($ret);
                    // }
    			$this->success('提交订单成功',"/index/personalorder/alist");
    		}
    		else{
    			$this->error('提交订单失败');
    		}

    }

}