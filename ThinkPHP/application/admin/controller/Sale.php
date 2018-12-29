<?php

namespace app\admin\controller;

use app\admin\controller\Common;

use think\Controller;
use think\Db;

class Sale extends Common
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

	public function saleBookDetail()
	{
		$sale_id = input('get.sale_id');
		$where = "sale_id = {$sale_id}";

		//级联查询
		$saleBookList = Db::table('sale_book')->alias('a')->where($where)
		->join('type_second b', 'a.sale_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->find();

		// $bookNumber = Db::table('sale_book')->alias('a')->where($where)
		// ->join('type_second b', 'a.sale_secondtype = b.second_id')
		// ->join('user c', 'a.user_id = c.user_id')
		// ->count();

		
		$this->assign('value', $saleBookList);
		// $this->assign('bookNumber', $bookNumber);


		return $this->fetch('saleBookDetail');
	}

	//添加书籍信息填写
	public function addPage()
	{
		$typeSecond = Db::table('type_second')->select();
		$users = Db::table('user')->select();

		$this->assign('typeSecond', $typeSecond);
		$this->assign('users', $users);

		return $this->fetch('saleBookAdd');
	}

	//修改出售书籍信息
	public function editPage()
	{
		//查找书籍
		$sale_id = input('get.sale_id');
		$where = "sale_id = {$sale_id}";
		$saleBook = Db::table('sale_book')->where($where)->find();

		if($saleBook == false)
		{
			$this->error('找不到该书籍');
		}

		//显示书籍类型和出售人
		$typeSecond = Db::table('type_second')->select();
		$users = Db::table('user')->select();

		//模板渲染
		$this->assign('typeSecond', $typeSecond);
		$this->assign('users', $users);
		$this->assign('edit', $saleBook);

		return $this->fetch('saleBookEdit');
	}

	//模糊查找
	public function saleBookSearch()
	{
		// dump($_POST);
		$search = input('post.search');

		if(!empty($search)) {
			session('salesearch', $search);
			$where['sale_name'] = array('like','%'.$search.'%');//封装模糊查询 赋值到数组	
		}
		else 
		{
			$search = session('salesearch');
			$where['sale_name'] = array('like','%'.$search.'%');	
		}

		
		//级联查询
		$saleBookList = Db::table('sale_book')
		->where($where)
		->alias('a')
		->join('type_second b', 'a.sale_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->paginate(15);

		$bookNumber = Db::table('sale_book')
		->where($where)
		->alias('a')
		->join('type_second b', 'a.sale_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->count();

		$this->assign('saleBookList', $saleBookList);
		$this->assign('bookNumber', $bookNumber);

		return $this->fetch('saleBooklist');

	}

	//添加出售书籍
	public function saleBookAdd()
	{
		//0.连接测试
		// dump($_POST);
		// dump($_FILES);
		// die();

  		//1.判断是否存在该书籍
		$isbn = input('post.isbn');

		$where = "sale_isbn = '{$isbn}'";
		// $res = Db::table('sale_book')->where($where)->find();

		// if (!empty($res)) {
		// 	$this->error('该书籍已存在'); 	
		// } 

		//2.获取数据
		$name 		= input('post.name');
		$author 	= input('post.author');
		$publishing = input('post.publishing');
		$img		= input('post.img');
		$beprice 	= input('post.beprice');
		$afprice 	= input('post.afprice');
		$num 		= input('post.num');
		$page 		= input('post.page');
		$degrees 	= input('post.degrees');
		$type 		= input('post.type');
		$user 		= input('post.user');
		$content 	= input('post.content');
		$sale_time 	= date("Y-m-d h:i:s", time());

		$new = [
			'全新'			=> 10,
			'九成新'		=> 9,
			'八成新'		=> 8,
			'七成新'		=> 7,
			'六成新及以下'	=> 6,
		];



		//3.构造数据
		$data = [
			'sale_isbn'			=>	$isbn,
			'sale_name'			=>	$name,
			'sale_author'		=>	$author,
			'sale_publishing'	=>	$publishing,
			'sale_img'			=>	$img,
			'sale_beprice'		=>	$beprice,
			'sale_afprice'		=>	$afprice,
			'sale_num'			=>	$num,
			'sale_volume'		=>	0,
			'sale_page'			=>	$page,
			'sale_degrees'		=>	$degrees,
			'sale_new'			=>	$new[$degrees],
			'sale_secondtype'	=>	$type,
			'user_id'			=>	$user,
			'sale_content'		=>	$content,
			'sale_time'			=>	$sale_time
		];

		//4.存入数据库
		$ret = Db::table('sale_book')->insert($data);

		if ($ret == false) {
			$this->error('添加出售书籍失败！');
		}

		//5.后续操作
		$this->success('添加出售书籍成功！', '/admin/sale/saleBookList');

	}

	//删除出售书籍
	public function saleBookDelete()
	{
		//0.测试
		// dump($_GET);

		//1.获取id
		$sale_id = input('get.sale_id');
		// dump($sale_id);

		//2.从数据库删除
		$where = "sale_id = {$sale_id}";
		// dump($where);

		//暂时取消外链，删除后恢复
		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('sale_book')->where($where)->delete();
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('删除出售书籍失败！','/admin/sale/saleBookList');
		}

		$this->success('删除出售书籍成功！', '/admin/sale/saleBookList');
	}

	//批量删除
	public function checkedBookDelete()
	{
		//0.测试
		// dump($_POST);

		//TP5的post方法不能提交数组，在表单name添加/a表示要提交有关数组，获取时同样要添加/a
		$ids = input('post.ids/a');

		foreach ($ids as $key => $id) {
			$where = "sale_id = {$id}";
			//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('sale_book')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');
		}

		$this->success('删除出售书籍成功！', '/admin/sale/saleBookList');
	}

	//编辑出售书籍
	public function saleBookEdit()
	{
		//0.测试
		// dump($_POST);

		//1.获取数据
		$id 		= input('post.id');
		$isbn 		= input('post.isbn');
		$name 		= input('post.name');
		$author 	= input('post.author');
		$publishing = input('post.publishing');
		$img		= input('post.img');
		$beprice 	= input('post.beprice');
		$afprice 	= input('post.afprice');
		$num 		= input('post.num');
		$page 		= input('post.page');
		$degrees 	= input('post.degrees');
		$type 		= input('post.type');
		$user 		= input('post.user');
		$content 	= input('post.content');
		$sale_time 	= date("Y-m-d h:i:s", time());

		//2.构造数据
		$data = [
			'sale_isbn'			=>	$isbn,
			'sale_name'			=>	$name,
			'sale_author'		=>	$author,
			'sale_publishing'	=>	$publishing,
			'sale_img'			=>	$img,
			'sale_beprice'		=>	$beprice,
			'sale_afprice'		=>	$afprice,
			'sale_num'			=>	$num,
			'sale_page'			=>	$page,
			'sale_degrees'		=>	$degrees,
			'sale_secondtype'	=>	$type,
			'user_id'			=>	$user,
			'sale_content'		=>	$content,
			'sale_time'			=>	$sale_time
		];

		//3.存入数据库
		$where = "sale_id = {$id}";
		$ret = Db::table('sale_book')->where($where)->update($data);

		if ($ret == false) {
			$this->error('修改出售书籍失败！');
		}

		//4.后续操作
		$this->success('修改出售书籍成功！', '/admin/sale/saleBookList');
		
	}

	//按销量排序
	public function orderByVolume()
	{
		$volume = Db::table('shoporder')
		->alias('a')
		->join('sale_book b', 'a.book_id = b.sale_id')
		->join('type_second c', 'b.sale_secondtype = c.second_id')
		->join('user d', 'b.user_id = d.user_id')
		->group('book_id')
		->field('sum(order_sum), b.*, c.*, d.*, a.*')
		->order('sum(order_sum)','desc')
		->paginate(15);

		// dump($volume);
		

		$bookNumber = Db::table('shoporder')
		->alias('a')
		->join('sale_book b', 'a.book_id = b.sale_id')
		->join('type_second c', 'b.sale_secondtype = c.second_id')
		->join('user d', 'b.user_id = d.user_id')
		->group('book_id')
		->field('book_id, sum(order_sum), b.*')
		->order('sum(order_sum)','desc')
		->count();

		$this->assign('saleBookList', $volume);
		$this->assign('bookNumber', $bookNumber);

		return $this->fetch('saleBooklist');
	}

	//按库存排序
	public function orderByNumber()
	{
		$saleBooklist = Db::table('sale_book')
		->alias('a')
		->join('type_second b', 'a.sale_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->order('sale_num', 'desc')
		->paginate(15);

		// dump($volume);
		

		$bookNumber = Db::table('sale_book')
		->order('sale_num', 'desc')
		->count();

		$this->assign('saleBookList', $saleBooklist);
		$this->assign('bookNumber', $bookNumber);

		return $this->fetch('saleBooklist');
	}

	//按价格从高到低排序
	public function orderByPriceDesc()
	{
		$saleBooklist = Db::table('sale_book')
		->alias('a')
		->join('type_second b', 'a.sale_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->order('sale_afprice', 'desc')
		->paginate(15);

		$bookNumber = Db::table('sale_book')
		->order('sale_afprice', 'desc')
		->count();

		$this->assign('saleBookList', $saleBooklist);
		$this->assign('bookNumber', $bookNumber);

		return $this->fetch('saleBooklist');
	}

	//按价格从低到高排序
	public function orderByPrice()
	{
		$saleBooklist = Db::table('sale_book')
		->alias('a')
		->join('type_second b', 'a.sale_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->order('sale_afprice')
		->paginate(15);

		$bookNumber = Db::table('sale_book')
		->order('sale_afprice')
		->count();

		$this->assign('saleBookList', $saleBooklist);
		$this->assign('bookNumber', $bookNumber);

		return $this->fetch('saleBooklist');
	}

}