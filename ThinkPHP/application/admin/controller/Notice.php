<?php

namespace app\admin\controller;

use app\admin\controller\Common;

use think\Controller;
use think\Db;

 class Notice extends Common
{
	public function index()
	{
		return $this->fetch('index');
	}

	//公告列表
	public function noticeList()
	{
		$noticeList = Db::table('notice')
		->alias('a')
		->join('admin b', 'a.admin_id = b.id')
		->paginate(15);

		$noticeNumber = Db::table('notice')
		->alias('a')
		->join('admin b', 'a.admin_id = b.id')
		->count();

		$this->assign('notice', $noticeList);
		$this->assign('to', $noticeNumber);

		return $this->fetch('noticeList');
	}

	public function addPage()
	{
		return $this->fetch('noticeAdd');
	}

	public function editPage()
	{
		$notice_id = input('get.notice_id');

		$where = "notice_id = {$notice_id}";

		$notice = Db::table('notice')->where($where)->find();

		$this->assign('notice', $notice);

		return $this->fetch('noticeEdit');

	}

	//添加公告
	public function noticeAdd()
	{
		// dump($_POST);

		//1.
		$title = input('post.title');
		$content = input('post.content');
		$admin_id = session('admin_id');

		//2.
		$data = [
			'notice_title'	=> $title,
			'notice_content'=> $content,
			'notice_time'	=> time(),
			'admin_id'		=> $admin_id,
			'view_time'		=> 0
		];

		//3.
		$ret = Db::table('notice')->insert($data);

		if ($ret == false) {
			$this->error('添加新公告失败！', '/admin/notice/noticeList');
		}

		$this->success('添加新公告成功！', '/admin/notice/noticeList');

	}


	//模糊查找
	public function noticeSearch()
	{
		// dump($_POST);
		$search = input('post.search');

		if(!empty($search)) {
			session('noticesearch', $search);
			$where['notice_title'] = array('like','%'.$search.'%');//封装模糊查询 赋值到数组	
		}
		else 
		{
			$search = session('noticesearch');
			$where['notice_title'] = array('like','%'.$search.'%');	
		}
		
		$noticeList = Db::table('notice')
		->where($where)
		->alias('a')
		->join('admin b', 'a.admin_id = b.id')
		->paginate(15);

		$noticeNumber = Db::table('notice')
		->where($where)
		->alias('a')
		->join('admin b', 'a.admin_id = b.id')
		->count();

		$this->assign('notice', $noticeList);
		$this->assign('to', $noticeNumber);

		return $this->fetch('noticeList');

	}

	public function noticeDelete()
	{
		// dump($_GET);

		//1.
		$notice_id = input('get.notice_id');
		$where = "notice_id = {$notice_id}";
		
		//2.
		//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('notice')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		//3.
		if ($ret == false) {
			$this->error('删除公告失败！', '/admin/notice/noticeList');
		}

		$this->success('删除公告成功！', '/admin/notice/noticeList');
	}

	//批量删除
	public function checkedNoticeDelete()
	{
		// dump($_POST);
		//TP5的post方法不能提交数组，在表单name添加/a表示要提交有关数组，获取时同样要添加/a
		$ids = input('post.ids/a');

		foreach ($ids as $key => $id) {
			$where = "notice_id = {$id}";
			//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('notice')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');
		}

		$this->success('删除公告成功！', '/admin/notice/noticeList');

	}

	//修改公告
	public function noticeEdit()
	{
		$title = input('post.title');
		$content = input('post.content');
		$notice_id = input('post.notice_id');
		$where = "notice_id = {$notice_id}";

		//2.
		$data = [
			'notice_title'	=> $title,
			'notice_content'=> $content
		];

		//3.
		$ret = Db::table('notice')->where($where)->update($data);

		if ($ret == false) {
			$this->error('修改公告失败！', '/admin/notice/noticeList');
		}

		$this->success('修改公告成功！', '/admin/notice/noticeList');

	}
}

