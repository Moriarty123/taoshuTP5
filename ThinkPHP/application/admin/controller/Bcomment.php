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

}