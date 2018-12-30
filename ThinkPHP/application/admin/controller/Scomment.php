<?php

namespace app\admin\controller;

use app\admin\controller\Common;

use think\Controller;
use think\Db;

class Scomment extends Common
{
	public function index()
	{
		return $this->fetch('index');
	}

	//求购书籍留言列表
	public function commentList()
	{
		$commentList = Db::table('scomment')
		->alias('a')
		->join('inquiry_book b', 'a.sbook_id = b.inquiry_id')
		->join('user c', 'a.user_id = c.user_id')
		->paginate(15);

		$commentNumber = Db::table('scomment')
		->alias('a')
		->join('inquiry_book b', 'a.sbook_id = b.inquiry_id')
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
		$inquiry_book = Db::table('inquiry_book')->select();

		$this->assign('users', $users);
		$this->assign('inquiry_book', $inquiry_book);

		return $this->fetch('commentAdd');
	}

	public function editPage()
	{
		// dump($_GET);
		$scomment_id = input('get.scomment_id');
		$where = "scomment_id = {$scomment_id}";
		$users = Db::table('user')->select();
		$inquiry_book = Db::table('inquiry_book')->select();
		
		$comment = Db::table('scomment')
		->where($where)
		->alias('a')
		->join('inquiry_book b', 'a.sbook_id = b.inquiry_id')
		->join('user c', 'a.user_id = c.user_id')
		->find();

		$this->assign('users', $users);
		$this->assign('inquiry_book', $inquiry_book);
		$this->assign('edit', $comment);

		return $this->fetch('commentEdit');
	}

	//添加留言
	public function commentAdd()
	{
		// dump($_POST);

		//1.获取数据
		$user_id = input('post.user_id');
		$inquiry_id = input('post.inquiry_id');
		$content = input('post.content');
		$time = time();

		//2.构造数据
		$data = [
			'user_id'			=> $user_id,
			'scomment_content'	=> $content,
			'sbook_id'			=> $inquiry_id,
			'scomment_time'		=> $time
		];
		
		//3.存入数据库
		$ret = Db::table('scomment')->insert($data);

		if ($ret == false) {
			$this->error('添加留言失败！');
		}

		//4.后续操作
		$this->success('添加留言成功！', '/admin/scomment/commentList');

	}

	//模糊查找
	public function commentSearch()
	{
		// dump($_POST);
		$search = input('post.search');

		if(!empty($search)) {
			session('commentsearch', $search);
			$where['scomment_content'] = array('like','%'.$search.'%');//封装模糊查询 赋值到数组	
		}
		else 
		{
			$search = session('commentsearch');
			$where['scomment_content'] = array('like','%'.$search.'%');	
		}

		
		$commentList = Db::table('scomment')
		->alias('a')
		->where($where)
		->join('inquiry_book b', 'a.sbook_id = b.inquiry_id')
		->join('user c', 'a.user_id = c.user_id')
		->paginate(15);

		$commentNumber = Db::table('scomment')
		->alias('a')
		->where($where)
		->join('inquiry_book b', 'a.sbook_id = b.inquiry_id')
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
		$scomment_id = input('get.scomment_id');
		// dump($inquiry_id);

		//2.从数据库删除
		$where = "scomment_id = {$scomment_id}";
		// dump($where);

		//暂时取消外链，删除后恢复
		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('scomment')->where($where)->delete();
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('删除留言失败！','/admin/scomment/commentList');
		}

		$this->success('删除留言成功！', '/admin/scomment/commentList');
	}

	//更新留言
	public function commentEdit()
	{
		// dump($_POST);

		//1.获取数据
		$scomment_id = input('post.scomment_id');
		$inquiry_id 	 = input('post.inquiry_id');
		$user_id 	 = input('post.user_id');
		$content 	 = input('post.content');

		//2.构造数据
		$data = [
			// 'scomment_id'		=> $scomment_id,
			'user_id'			=> $user_id,
			'scomment_content'	=> $content,
			'scomment_time'		=> time(),
			'sbook_id'			=> $inquiry_id
		];
		// dump($data);die();
		//3.存入数据库
		$where = "scomment_id = {$scomment_id}";
		$ret = Db::table('scomment')->where($where)->update($data);
		
		if ($ret == false) {
			$this->error('修改留言失败！', '/admin/scomment/commentList');
		}

		$this->success('修改留言成功！', '/admin/scomment/commentList');
	}

	//批量删除
	public function checkedCommentDelete()
	{
		
		//TP5的post方法不能提交数组，在表单name添加/a表示要提交有关数组，获取时同样要添加/a
		$ids = input('post.ids/a');
		// dump($ids);
		// $count = count($ids);

		foreach ($ids as $key => $id) {
			$where = "scomment_id = {$id}";
			//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('scomment')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');
		}

		$this->success('删除留言成功！', '/admin/scomment/commentList');

	}

}