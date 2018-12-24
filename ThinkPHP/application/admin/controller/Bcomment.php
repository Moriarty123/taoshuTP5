<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

class Bcomment extends Controller 
{
	public function index()
	{
		return $this->fetch('index');
	}

	//出售书籍留言列表
	public function commentList()
	{
		$commentList = Db::table('bcomment')
		->alias('a')
		->join('sale_book b', 'a.bbook_id = b.sale_id')
		->join('user c', 'a.user_id = c.user_id')
		->paginate(15);

		$commentNumber = Db::table('bcomment')
		->alias('a')
		->join('sale_book b', 'a.bbook_id = b.sale_id')
		->join('user c', 'a.user_id = c.user_id')
		->count();

		$this->assign('commentList', $commentList);
		$this->assign('commentNumber', $commentNumber);

		return $this->fetch('commentList');
	}

	//添加页面
	public function addPage()
	{
		$users = Db::table('user')->select();
		$sale_book = Db::table('sale_book')->select();

		$this->assign('users', $users);
		$this->assign('sale_book', $sale_book);

		return $this->fetch('commentAdd');
	}

	//添加留言
	public function commentAdd()
	{
		// dump($_POST);

		//1.获取数据
		$user_id = input('post.user_id');
		$sale_id = input('post.sale_id');
		$content = input('post.content');
		$time = time();

		//2.构造数据
		$data = [
			'user_id'			=> $user_id,
			'bcomment_content'	=> $content,
			'bbook_id'			=> $sale_id,
			'bcomment_time'		=> $time
		];
		
		//3.存入数据库
		$ret = Db::table('bcomment')->insert($data);

		if ($ret == false) {
			$this->error('添加留言失败！');
		}

		//4.后续操作
		$this->success('添加留言成功！', '/admin/bcomment/commentList');

	}

}