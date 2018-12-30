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

	//批量删除
	public function checkedReplyDelete()
	{
		//TP5的post方法不能提交数组，在表单name添加/a表示要提交有关数组，获取时同样要添加/a
		$ids = input('post.ids/a');

		foreach ($ids as $key => $id) {
			$where = "reply_id = {$id}";
			//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('bcomment_reply')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');
		}

		$this->success('删除留言成功！', '/admin/breply/replyList');
	}

	//模糊查找
	public function replySearch()
	{
		// dump($_POST);
		$search = input('post.search');

		if(!empty($search)) {
			session('replysearch', $search);
			$where['reply_content'] = array('like','%'.$search.'%');//封装模糊查询 赋值到数组	
		}
		else 
		{
			$search = session('replysearch');
			$where['reply_content'] = array('like','%'.$search.'%');	
		}

		// dump($where);

		$replyList = Db::table('bcomment_reply')
		->where($where)
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('bcomment c', 'a.comment_id = c.bcomment_id')
		->paginate(15);

		$replyNumber = Db::table('bcomment_reply')
		->where($where)
		->alias('a')
		->join('user b', 'a.user_id = b.user_id')
		->join('bcomment c', 'a.comment_id = c.bcomment_id')
		->count();

		$this->assign('reply', $replyList);
		$this->assign('to', $replyNumber);

		return $this->fetch('replyList');

	}

	//屏蔽留言
	public function changeState()
	{
		//1.获取数据
		$reply_id = input('get.reply_id');

		//2.获取屏蔽状态
		//2.1查找回复
		$where = "reply_id = {$reply_id}";
		$reply = Db::table('bcomment_reply')->where($where)
		->find();

		if(empty($reply))
		{
			$this->error('找不到该回复！');
		}

		//2.2
		$status = $reply['reply_status'];
		$status = $status==0?1:0;
		// dump($status);

		$data = [
			'reply_status' => $status
		];

		//暂时取消外链，删除后恢复
		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('bcomment_reply')->where($where)->update($data);
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('修改屏蔽状态失败！','/admin/breply/replyList');
		}

		$this->success('修改屏蔽状态成功！', '/admin/breply/replyList');

	}
	

}

