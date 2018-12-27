<?php

namespace app\admin\controller;

use app\admin\controller\Common;

use think\Controller;
use think\Db;

 class inquiry extends Common
 {
	public function index()
	{
		return $this->fetch('index');
	}

	public function inquiryBookList()
	{
		//级联查询
		$inquiryBookList = Db::table('inquiry_book')->alias('a')
		->join('type_second b', 'a.inquiry_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->paginate(15);

		$bookNumber = Db::table('inquiry_book')->alias('a')
		->join('type_second b', 'a.inquiry_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->count();

		
		$this->assign('inquiryBookList', $inquiryBookList);
		$this->assign('bookNumber', $bookNumber);

		return $this->fetch('inquiryBookList');
	}

	//添加书籍信息填写
	public function addPage()
	{
		$typeSecond = Db::table('type_second')->select();
		$users = Db::table('user')->select();

		$this->assign('typeSecond', $typeSecond);
		$this->assign('users', $users);

		return $this->fetch('inquiryBookAdd');
	}

	//修改求购书籍信息
	public function editPage()
	{
		//查找书籍
		$inquiry_id = input('get.inquiry_id');
		$where = "inquiry_id = {$inquiry_id}";
		$inquiryBook = Db::table('inquiry_book')->where($where)->find();

		if($inquiryBook == false)
		{
			$this->error('找不到该书籍');
		}

		//显示书籍类型和求购人
		$typeSecond = Db::table('type_second')->select();
		$users = Db::table('user')->select();

		//模板渲染
		$this->assign('typeSecond', $typeSecond);
		$this->assign('users', $users);
		$this->assign('edit', $inquiryBook);

		return $this->fetch('inquiryBookEdit');
	}

	//模糊查找
	public function inquiryBookSearch()
	{
		// dump($_POST);
		$search = input('post.search');

		if(!empty($search)) {
			session('inquirysearch', $search);
			$where['inquiry_name'] = array('like','%'.$search.'%');//封装模糊查询 赋值到数组	
		}
		else 
		{
			$search = session('inquirysearch');
			$where['inquiry_name'] = array('like','%'.$search.'%');	
		}

		
		//级联查询
		$inquiryBookList = Db::table('inquiry_book')
		->where($where)
		->alias('a')
		->join('type_second b', 'a.inquiry_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->paginate(15);

		$bookNumber = Db::table('inquiry_book')
		->where($where)
		->alias('a')
		->join('type_second b', 'a.inquiry_secondtype = b.second_id')
		->join('user c', 'a.user_id = c.user_id')
		->count();

		$this->assign('inquiryBookList', $inquiryBookList);
		$this->assign('bookNumber', $bookNumber);

		return $this->fetch('inquiryBookList');

	}

	//添加求购书籍
	public function inquiryBookAdd()
	{
		//0.连接测试
		// dump($_POST);
		// dump($_FILES);
		// die();

  		//1.判断是否存在该书籍
		// $isbn = input('post.isbn');

		// $where = "inquiry_isbn = '{$isbn}'";
		// $res = Db::table('inquiry_book')->where($where)->find();

		// if (!empty($res)) {
		// 	$this->error('该书籍已存在'); 	
		// } 

		//2.获取数据
		$isbn 		= input('post.isbn');
		$name 		= input('post.name');
		$author 	= input('post.author');
		$publishing = input('post.publishing');
		$img		= input('post.img');
		$minprice 	= input('post.minprice');
		$maxprice 	= input('post.maxprice');
		$num 		= input('post.num');
		$page 		= input('post.page');
		$degrees 	= input('post.degrees');
		$type 		= input('post.type');
		$user 		= input('post.user');
		$content 	= input('post.content');
		$attach		= input('post.attach');
		$time 		= date("Y-m-d h:i:s", time());

		//3.构造数据
		$data = [
			'inquiry_isbn'			=>	$isbn,
			'inquiry_name'			=>	$name,
			'inquiry_author'		=>	$author,
			'inquiry_publishing'	=>	$publishing,
			'inquiry_img'			=>	$img,
			'inquiry_minprice'		=>	$minprice,
			'inquiry_maxprice'		=>	$maxprice,
			'inquiry_num'			=>	$num,
			'inquiry_page'			=>	$page,
			'inquiry_degrees'		=>	$degrees,
			'inquiry_secondtype'	=>	$type,
			'user_id'				=>	$user,
			'inquiry_content'		=>	$content,
			'inquiry_attach'		=>	$attach,
			'inquiry_time'			=>	$time
		];

		//4.存入数据库
		$ret = Db::table('inquiry_book')->insert($data);

		if ($ret == false) {
			$this->error('添加求购书籍失败！');
		}

		//5.后续操作
		$this->success('添加求购书籍成功！', '/admin/inquiry/inquiryBookList');

	}

	//删除求购书籍
	public function inquiryBookDelete()
	{
		//0.测试
		// dump($_GET);

		//1.获取id
		$inquiry_id = input('get.inquiry_id');
		// dump($inquiry_id);

		//2.从数据库删除
		$where = "inquiry_id = {$inquiry_id}";
		// dump($where);

		//暂时取消外链，删除后恢复
		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('inquiry_book')->where($where)->delete();
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('删除求购书籍失败！','/admin/inquiry/inquiryBookList');
		}

		$this->success('删除求购书籍成功！', '/admin/inquiry/inquiryBookList');
	}


	//批量删除
	public function checkedBookDelete()
	{
		//0.测试
		// dump($_POST);

		//TP5的post方法不能提交数组，在表单name添加/a表示要提交有关数组，获取时同样要添加/a
		$ids = input('post.ids/a');

		foreach ($ids as $key => $id) {
			$where = "inquiry_id = {$id}";
			//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('inquiry_book')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');
		}

		$this->success('删除求购书籍成功！', '/admin/inquiry/inquiryBookList');
	}

	//编辑求购书籍
	public function inquiryBookEdit()
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
		$minprice 	= input('post.minprice');
		$maxprice 	= input('post.maxprice');
		$num 		= input('post.num');
		$page 		= input('post.page');
		$degrees 	= input('post.degrees');
		$type 		= input('post.type');
		$user 		= input('post.user');
		$content 	= input('post.content');
		$attach     = input('post.attach');
		$inquiry_time 	= date("Y-m-d h:i:s", time());

		//2.构造数据
		$data = [
			'inquiry_isbn'			=>	$isbn,
			'inquiry_name'			=>	$name,
			'inquiry_author'		=>	$author,
			'inquiry_publishing'	=>	$publishing,
			'inquiry_img'			=>	$img,
			'inquiry_minprice'		=>	$minprice,
			'inquiry_maxprice'		=>	$maxprice,
			'inquiry_num'			=>	$num,
			'inquiry_page'			=>	$page,
			'inquiry_degrees'		=>	$degrees,
			'inquiry_secondtype'	=>	$type,
			'user_id'				=>	$user,
			'inquiry_content'		=>	$content,
			'inquiry_attach'		=>	$attach,
			'inquiry_time'			=>	$inquiry_time
		];

		//3.存入数据库
		$where = "inquiry_id = {$id}";
		$ret = Db::table('inquiry_book')->where($where)->update($data);

		if ($ret == false) {
			$this->error('修改求购书籍失败！');
		}

		//4.后续操作
		$this->success('修改求购书籍成功！', '/admin/inquiry/inquiryBookList');
		
	}

}