<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

 class Notice extends Controller 
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


}