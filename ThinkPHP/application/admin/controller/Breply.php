<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

 class Breply extends Controller 
{
	public function index()
	{
		return $this->fetch('index');
	}

	public function replyList()
	{
		$replyList = Db::table('bcomment_reply')
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('bcomment c', 'a.comment_id = c.bcomment_id')
		->paginate(15);

		// dump($replyList);

		$replyNumber = Db::table('bcomment_reply')
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('bcomment c', 'a.comment_id = c.bcomment_id')
		->count();

		$this->assign('reply', $replyList);
		$this->assign('to', $replyNumber);

		return $this->fetch('replyList');
	}


}