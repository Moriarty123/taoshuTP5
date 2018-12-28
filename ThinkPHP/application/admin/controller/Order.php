<?php

namespace app\admin\controller;

use app\admin\controller\Common;

use think\Controller;
use think\Db;

class Order extends Common 
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

		// dump($order);

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

	//编辑信息填写页面
	public function editPage()
	{
		//查找特定ID的订单
		$order_id = input('get.order_id');
		$where = "order_id = {$order_id}";

		$user = Db::table('user')->select();
		$sale_book = Db::table('sale_book')->select();

		$order = Db::table('shoporder')->where($where)
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('sale_book c', 'a.book_id = c.sale_id')
		->field('b.*, c.*, a.*')
		->find();

		// dump($order);

		$this->assign('edit', $order);
		$this->assign('user', $user);
		$this->assign('book', $sale_book);

		return $this->fetch('orderEdit');
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

		//3.存入数据库
		$ret = Db::table('shoporder')->insert($data);
		//3.1书籍库存减少
		$res = Db::table('sale_book')
		->where("sale_id = {$sale_id}")
		->setDec('sale_num', $num);

		if ($ret == false) {
			$this->error('添加订单失败！');
		}

		$this->success('添加订单成功！', '/admin/order/orderList');
	}

	public function changeState()
	{
		$order_id = input('get.order_id');

		$where = "order_id = {$order_id}";

		$ret = Db::table('shoporder')->where($where)->update(['order_state' => 1]);

		if ($ret == false) {
			$this->error('修改订单状态失败！');
		}

		$this->success('修改订单状态成功！', '/admin/order/orderList');
	}

	//模糊查找
	public function orderSearch()
	{
		// dump($_POST);
		$search = input('post.search');

		if(!empty($search)) {
			session('ordersearch', $search);
			$where['order_id'] = array('like','%'.$search.'%');//封装模糊查询 赋值到数组	
		}
		else 
		{
			$search = session('ordersearch');
			$where['order_id'] = array('like','%'.$search.'%');	
		}
		// dump();
		
		//获取订单
		$order = Db::table('shoporder')
		->where($where)
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('sale_book c', 'a.book_id = c.sale_id')
		->order('create_time','desc')
		->paginate(15);

		$orderNumber = Db::table('shoporder')
		->where($where)
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('sale_book c', 'a.book_id = c.sale_id')
		->count();

		$this->assign('order', $order);
		$this->assign('to', $orderNumber);

		return $this->fetch('orderList');

	}

	//删除订单
	public function orderDelete()
	{
		// dump($_GET);
		$order_id = input('get.order_id');
		$where = "order_id = {$order_id}";

		//暂时取消外链，删除后恢复
		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('shoporder')->where($where)->delete();
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('删除订单失败！');
		}

		$this->success('删除订单成功！', '/admin/order/orderList');
	}
	
	//批量删除
	public function checkedOrderDelete()
	{
		// dump($_POST);
		//TP5的post方法不能提交数组，在表单name添加/a表示要提交有关数组，获取时同样要添加/a
		$ids = input('post.ids/a');
		// dump($ids);
		// $count = count($ids);

		foreach ($ids as $key => $id) {
			$where = "order_id = {$id}";
			//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('shoporder')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');
		}

		$this->success('删除订单成功！', '/admin/order/orderList');

	}

	//更新订单
	public function orderEdit()
	{
		// dump($_POST);
		//1.获取数据
		$order_id 	 = input('post.id');
		$user_id 	 = input('post.user');
		$sale_id 	 = input('post.name');
		$order_num 	 = input('post.num');
		$order_price = input('post.price');

		//2.构造数据
		$data = [
			'user_id'	=> $user_id,
			'book_id'	=> $sale_id,
			'order_sum'	=> $order_num,
			'order_price'=> $order_price
		];
		// dump($data);
		//3.存入数据库
		$where = "order_id = '{$order_id}'";

		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('shoporder')->where($where)->update($data);
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('修改订单失败！', '/admin/order/orderList');
		}

		$this->success('修改订单成功！', '/admin/order/orderList');
	}
}