<?php

namespace app\admin\controller;

use app\admin\controller\Common;

use think\Controller;
use think\Db;
use think\Log;

class Violation extends Common 
{
	public function index()
	{
		return $this->fetch('index');
	}

	//违规用户处理列表
	public function violateList()
	{
		$violateList = Db::table('Violation')
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->paginate(15);

		$violateNumber = Db::table('Violation')
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->count();

		$this->assign('violateList', $violateList);
		$this->assign('violateNumber', $violateNumber);

		Log::record('显示违规用户处理列表violateList.html', 'notice');

		return $this->fetch('violateList');
	}

	//添加违规页面
	public function addPage()
	{	
		Log::record('添加新违规', 'notice');

		$user = Db::table('user')->select();

		$this->assign('user', $user);

		return $this->fetch('violateAdd');
	}

	//添加违规
	public function violateAdd()
	{
		// dump($_POST);

		//1.
		$user_id 		= input('post.user_id');
		$punish_time 	= input('post.punish_time');
		$punish_case 	= input('post.punish_case');
		$punish_way 	= input('post.punish_way');

		//2.
		$data = [
			'user_id' => $user_id,
			'punish_time'=> $punish_time,
			'punish_case' => $punish_case,
			'punish_way' => $punish_way,
			'add_time' => time()
		];

		$ret = Db::table('violation')->insert($data);

		if($ret == false)
		{
			$this->error('添加新违规失败！', '/admin/violation/violateList');
		}

		$this->success('添加新违规成功！', '/admin/violation/violateList');

	}

}