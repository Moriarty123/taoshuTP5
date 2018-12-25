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

	public function order()
	{
		//获取订单
		$order = Db::table('shoporder')
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('sale_book c', 'a.book_id = c.sale_id')
		->paginate(15);

		$orderNumber = Db::table('shoporder')
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('sale_book c', 'a.book_id = c.sale_id')
		->count();

		$this->assign('order', $order);
		$this->assign('to', $orderNumber);

		return $this->fetch('order');
	}


}