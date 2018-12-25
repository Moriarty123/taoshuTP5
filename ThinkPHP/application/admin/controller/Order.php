<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

class Order extends Controller 
{
	public function index()
	{
		return $this->fetch('index');
	}

	public function orderList()
	{
		//获取订单
		$order = Db::table('shoporder')
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('sale_book c', 'a.book_id = c.sale_id')
		->order('create_time','desc')
		->paginate(15);

		$orderNumber = Db::table('shoporder')
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('sale_book c', 'a.book_id = c.sale_id')
		->count();

		$this->assign('order', $order);
		$this->assign('to', $orderNumber);

		return $this->fetch('orderList');
	}

	//添加订单填写页面
	public function addPage()
	{
		$user = Db::table('user')->select();
		$sale_book = Db::table('sale_book')->select();

		$this->assign('user', $user);
		$this->assign('book', $sale_book);

		return $this->fetch('orderAdd');
	}

	//添加订单
	public function orderAdd()
	{
		// dump($_POST);
		//1.获取数据
		$user_id 	= input('post.user');
		$sale_id 	= input('post.name');
		$num 		= input('post.num');
		$price 		= input('post.price');

		$order_id = date("Y-m-dH-i-s");
		$order_id = str_replace("-","",$order_id);
		$order_id .= $user_id;
		$order_id .= rand(100000,999999);

		//2.构造数据
		$data = [
			'order_id'		=> $order_id,
			'user_id' 		=> $user_id,
			'book_id' 		=> $sale_id,
			'order_sum' 	=> $num,
			'order_price' 	=> $price,
			'create_time'	=> time(),
			'order_state'	=> 0,
			'order_buy'		=> 0,
			'order_sale'	=> 0
		];
		// dump($data);
		// die();
		//3.存入数据库
		$ret = Db::table('shoporder')->insert($data);

		if ($ret == false) {
			$this->error('添加订单失败！');
		}

		$this->success('添加订单成功！', '/admin/order/orderList');
	}


}