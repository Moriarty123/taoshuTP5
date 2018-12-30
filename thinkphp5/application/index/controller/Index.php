<?php
namespace app\index\controller;

use think\Db;
use think\Controller;

class Index extends Controller
{
	//主页显示
    public function index(){
    	// var_dump(session('username'));die;
        $obj = model('index');
		$book_type = $obj->GetAllBookType();
		
		$type_second_jj = $obj->GetTypeSecond_jj();	//经济金融
		$type_second_jsj = $obj->GetTypeSecond_jsj();	//计算机与网络
		$type_second_gl = $obj->GetTypeSecond_gl();	//管理
		$type_second_yy = $obj->GetTypeSecond_yy();	//语言学习
		$type_second_wx = $obj->GetTypeSecond_wx();	//文学小说
		$type_second_yx = $obj->GetTypeSecond_yx();	//医学卫生
		$type_second_jy = $obj->GetTypeSecond_jy();	//教育考试
		
		$type_second_ajj = $obj->GetAllTypeSecond_jj();	//经济金融
		$type_second_ajsj = $obj->GetAllTypeSecond_jsj();	//计算机与网络
		$type_second_agl = $obj->GetAllTypeSecond_gl();	//管理
		$type_second_ayy = $obj->GetAllTypeSecond_yy();	//语言学习
		$type_second_awx = $obj->GetAllTypeSecond_wx();	//文学小说
		$type_second_ayx = $obj->GetAllTypeSecond_yx();	//医学卫生
		$type_second_ajy = $obj->GetAllTypeSecond_jy();	//教育考试
		
		$sale_book = $obj->GetNewSaleBook();	//获取最新出售书籍
		$inquiry_book = $obj->GetNewInquiry();	//获取最新求购书籍
		
		$notice = $obj->GetNotice();	// 获取公告信息
		//获取本周开始结束时间戳
		$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
		$endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7,date('Y'));
		//本月
		$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
		//本年
		$beginThisyear=mktime(0,0,0,1,1,date('Y'));
		$endThisyear=mktime(23,59,59,1,1,date('Y')+1);
		//本周热销
		$ret_w = db("shoporder")->where("create_time<{$endLastweek} and create_time>{$beginLastweek}")->group("book_id")->field('book_id,sum(order_sum) as a')->order('a','desc')->limit('0,5')->select();
		$ret_ww =[];
		foreach ($ret_w as $key => $vo) {
			$ret = db('sale_book')->where("sale_id={$vo['book_id']}")->find();
			$vo['book_name'] = $ret['sale_name'];
			$ret_ww[] = $vo;
		}
		
		//本月热销
		$ret_m = db("shoporder")->where("create_time<{$endThismonth} and create_time>{$beginThismonth}")->group("book_id")->field('book_id,sum(order_sum) as a')->order('a','desc')->limit('0,5')->select();
		$ret_mm =[];
		foreach ($ret_m as $key => $va) {
			$ret = db('sale_book')->where("sale_id={$va['book_id']}")->find();
			$va['book_name'] = $ret['sale_name'];
			$ret_mm[] = $va;
		}
		//本年热销
		$ret_y = db("shoporder")->where("create_time<{$endThisyear} and create_time>{$beginThisyear}")->group("book_id")->field('book_id,sum(order_sum) as a')->order('a','desc')->limit('0,5')->select();
		$ret_yy =[];
		foreach ($ret_y as $key => $vb) {
			$ret = db('sale_book')->where("sale_id={$vb['book_id']}")->find();
			$vb['book_name'] = $ret['sale_name'];
			$ret_yy[] = $vb;
		}
		
		$this->assign('ret_w',$ret_ww);
		$this->assign('ret_m',$ret_mm);
		$this->assign('ret_y',$ret_yy);

		$this->assign([
			'type_second_jj' 	=>	$type_second_jj,
			'type_second_jsj'	=> 	$type_second_jsj,
			'type_second_gl' 	=>	$type_second_gl,	 
			'type_second_yy' 	=> 	$type_second_yy,
			'type_second_wx' 	=>	$type_second_wx,
			'type_second_yx' 	=>	$type_second_yx,
			'type_second_jy'	=>	$type_second_jy,

			'type_second_ajj' 	=>	$type_second_ajj,
			'type_second_ajsj' =>	$type_second_ajsj,
			'type_second_agl' 	=>	$type_second_agl,
			'type_second_ayy'	=>	$type_second_ayy,
			'type_second_awx'  =>	$type_second_awx,
			'type_second_ayx' 	=>	$type_second_ayx,
			'type_second_ajy'  => 	$type_second_ajy,
			
			'sale_book'	 	=>	$sale_book,
			'inquiry_book'		=>	$inquiry_book,
			
			'notice'			=>	$notice
		]);

		return  $this->fetch('index');
    }
   
}
