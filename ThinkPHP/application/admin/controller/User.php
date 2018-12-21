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

	//用户列表
	public function userList()
	{
		$userList = Db::table('user')->paginate(15);
		$userNumber = Db::table('user')->count();

		$this->assign('userList', $userList); 
		$this->assign('userNumber', $userNumber);

		return $this->fetch('userList');
	}

	//添加用户信息填写
	public function userPage()
	{
		$class = Db::table('class')->select();

		$this->assign('class', $class);
		return $this->fetch('userAdd');
	}

	public function userAdd()
	{
		dump($_POST);
	}

}