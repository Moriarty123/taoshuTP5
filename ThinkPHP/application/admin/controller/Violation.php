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


}