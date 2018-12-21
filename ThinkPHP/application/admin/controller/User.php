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
	public function addPage()
	{
		$classes = Db::table('class')->select();

		$this->assign('classes', $classes);
		return $this->fetch('userAdd');
	}

	//编辑用户信息填写
	public function editPage()
	{
		//查找特定ID的用户
		$user_id = input('get.user_id');
		$where = "user_id = {$user_id}";
		$user = Db::table('user')->where($where)->find();
		$this->assign('user', $user);

		$classes = Db::table('class')->select();
		$this->assign('classes', $classes);

		return $this->fetch('userEdit');
	}

	//添加用户
	public function userAdd()
	{
		// dump($_POST);

		//1.获取数据
		$name = input('post.name');
		$pwd = input('post.pwd');
		$sex = input('post.sex');
		$realname = input('post.realname');
		$img = input('post.headImg');
		$tel = input('post.tel');
		$addr = input('post.addr');
		$grade = input('post.grade');
		$class_id = input('post.class');
		$content = input('post.content');

		//2.构造数据
		$data = [
			'user_name'		=> 	$name,
			'user_pwd'		=> 	md5($pwd),
			'user_sex'		=> 	$sex,
			'user_realname'	=>	$realname,
			'user_img'		=> 	$img,
			'user_tel'		=> 	$tel,
			'user_addr'		=> 	$addr,
			'grade'			=> 	$grade,
			'class_id'		=> 	$class_id,
			'user_content'	=> 	$content
		];

		//3.存入数据库
		$where = "user_name = {$name}";
		$res = Db::table('user')->where($where)->find();

		if (!empty($res)) {
			$this->error('该用户已注册');
		}
		$ret = Db::table('user')->insert($data);

		if ($ret == false) {
			$this->error('添加用户失败');

		}

		//4.后续操作
		$this->success('添加成功', '/admin/user/userList');
	}

	//更新用户信息
	public function userUpdate()
	{
		// dump($_POST);
		//1.获取数据
		$id = input('post.id');
		$name = input('post.name');
		$pwd = input('post.pwd');
		$sex = input('post.sex');
		$realname = input('post.realname');
		$img = input('post.headImg');
		$tel = input('post.tel');
		$addr = input('post.addr');
		$grade = input('post.grade');
		$class_id = input('post.class');
		$content = input('post.content');

		//2.构造数据
		$data = [
			'user_name'		=> 	$name,
			'user_pwd'		=> 	md5($pwd),
			'user_sex'		=> 	$sex,
			'user_realname'	=>	$realname,
			'user_img'		=> 	$img,
			'user_tel'		=> 	$tel,
			'user_addr'		=> 	$addr,
			'grade'			=> 	$grade,
			'class_id'		=> 	$class_id,
			'user_content'	=> 	$content
		];

		//3.存入数据库
		$where = "user_id = {$id}";
		
		$ret = Db::table('user')->where($where)->update($data);

		if ($ret == false) {
			$this->error('更新用户信息失败');

		}

		//4.后续操作
		$this->success('更新用户信息成功', '/admin/user/userList');
	}

}