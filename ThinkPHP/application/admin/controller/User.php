<?php 

namespace app\admin\controller;

use think\Controller;
use think\Db;

class User extends Controller
{
	public function index()
	{
		return $this->fetch('userList');
	}

	public function userList()
	{
		$userList = Db::table('user')->select();
		// $userNumber = Db::table('user')->count();

		$this->assign('userList', $userList); 
		// $this->assign('userNumber', $count);

		return $this->fetch('userList');
	}

}