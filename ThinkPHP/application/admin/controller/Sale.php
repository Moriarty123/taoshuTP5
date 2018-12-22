<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

 class Sale extends Controller 
{
	public function index()
	{
		return $this->fetch('index');
	}

	public function saleBookList()
	{
		//级联查询
		$saleBookList = Db::table('sale_book')->alias('a')
		->join('type_second b', 'a.sale_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->paginate(15);

		$bookNumber = Db::table('sale_book')->alias('a')
		->join('type_second b', 'a.sale_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->count();

		
		$this->assign('saleBookList', $saleBookList);
		$this->assign('bookNumber', $bookNumber);

		return $this->fetch('saleBookList');
	}


}