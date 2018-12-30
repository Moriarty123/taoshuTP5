<?php 

namespace app\admin\controller;

use app\admin\controller\Common;

use think\Controller;
use think\Db;
use think\Log;

class User extends Common
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
		// dump($userList);
		$this->assign('userList', $userList); 
		$this->assign('userNumber', $userNumber);

		//日志
		Log::record('显示用户列表userList.html','notice');

		return $this->fetch('userList');
	}

	//添加用户信息填写
	public function addPage()
	{
		$classes = Db::table('class')->select();

		$this->assign('classes', $classes);

		//日志
		Log::record('跳转到添加用户界面addPage.html','notice');

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

	//修改密码页面
	public function pwdPage()
	{
		//查找特定ID的用户
		$user_id = input('get.user_id');
		$where = "user_id = {$user_id}";
		$user = Db::table('user')->where($where)->find();
		$this->assign('user', $user);

		return $this->fetch('pwdEdit');
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

	//模糊查找
	public function userSearch()
	{
		// dump($_POST);
		$search = input('post.search');

		if(!empty($search)) {
			session('usersearch', $search);
			$where['user_name'] = array('like','%'.$search.'%');//封装模糊查询 赋值到数组	
		}
		else 
		{
			$search = session('usersearch');
			$where['user_name'] = array('like','%'.$search.'%');	
		}

		
		$userList = Db::table('user')->where($where)->paginate(15);
		$this->assign('userList', $userList);

		$userNumber = Db::table('user')->where($where)->count();
		$this->assign('userNumber', $userNumber);

		return $this->fetch('userList');

	}

	//修改密码
	public function pwdUpdate()
	{
		// dump($_POST);

		//1.获取数据
		$id = input('post.id');
		$pwd = input('post.pwd');

		//修改密码
		$where = "user_id = {$id}";
		$pwd = md5($pwd);
		$ret = Db::table('user')->where($where)->update(['user_pwd' => $pwd]);

		if ($ret == false) {
			$this->error('修改密码失败！');
		}

		$this->success('修改密码成功！', '/admin/user/userList');

	}

	//删除用户
	public function userDelete()
	{
		// dump($_GET);

		$user_id = input('get.user_id');
		$where = "user_id = {$user_id}";

		// $user = Db::table('user')->where($where)->find();

		//删除关联数据
		// if (!empty($user)) {
		// 	Db::table('sale_book')->where($where)->delete();
		// 	Db::table('inquiry_book')->where($where)->delete();
		// 	Db::table('scomment')->where($where)->delete();
		// 	Db::table('bcomment')->where($where)->delete();
		// 	Db::table('shopcar')->where($where)->delete();
		// 	Db::table('shoporder')->where($where)->delete();
		// }

		//暂时取消外链，删除后恢复
		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('user')->where($where)->delete();
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('删除用户失败！');
		}

		$this->success('删除用户成功！', '/admin/user/userList');
	}

	//批量删除
	public function checkedUserDelete()
	{
		// dump($_POST);
		//TP5的post方法不能提交数组，在表单name添加/a表示要提交有关数组，获取时同样要添加/a
		$ids = input('post.ids/a');
		// dump($ids);
		// $count = count($ids);

		foreach ($ids as $key => $id) {
			$where = "user_id = {$id}";
			//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('user')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');
		}

		$this->success('删除用户成功！', '/admin/user/userList');

	}
}