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

	//删除回复
	public function replyDelete()
	{
		$reply_id = input('get.reply_id');

		$where = "reply_id = {$reply_id}";

		

		//暂时取消外链，删除后恢复
		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('bcomment_reply')->where($where)->delete();
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('删除回复失败！','/admin/breply/replyList');
		}

		$this->success('删除回复成功！', '/admin/breply/replyList');

	}


}

