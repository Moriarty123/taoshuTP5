<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

class Sale extends Controller 
{
	//显示所有出售书籍
	function showAllSaleBook() {

		$ret = Db::name('sale_book')->paginate(5);

		$this->assign('saleBookList', $ret);

		return $this->fetch('showAllSaleBook');

	}

}
