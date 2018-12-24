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

	//模糊查找
	public function commentSearch()
	{
		// dump($_POST);
		$search = input('post.search');

		if(!empty($search)) {
			session('commentsearch', $search);
			$where['bcomment_content'] = array('like','%'.$search.'%');//封装模糊查询 赋值到数组	
		}
		else 
		{
			$search = session('commentsearch');
			$where['bcomment_content'] = array('like','%'.$search.'%');	
		}

		
		$commentList = Db::table('bcomment')
		->alias('a')
		->where($where)
		->join('sale_book b', 'a.bbook_id = b.sale_id')
		->join('user c', 'a.user_id = c.user_id')
		->paginate(15);

		$commentNumber = Db::table('bcomment')
		->alias('a')
		->where($where)
		->join('sale_book b', 'a.bbook_id = b.sale_id')
		->join('user c', 'a.user_id = c.user_id')
		->count();

		$this->assign('commentList', $commentList);
		$this->assign('commentNumber', $commentNumber);

		return $this->fetch('commentList');

	}

	//删除留言
	public function commentDelete()
	{
		//0.测试
		// dump($_GET);

		//1.获取id
		$bcomment_id = input('get.bcomment_id');
		// dump($sale_id);

		//2.从数据库删除
		$where = "bcomment_id = {$bcomment_id}";
		// dump($where);

		//暂时取消外链，删除后恢复
		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('bcomment')->where($where)->delete();
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('删除出售书籍留言失败！','/admin/bcomment/commentList');
		}

		$this->success('删除出售书籍留言成功！', '/admin/bcomment/commentList');
	}

}