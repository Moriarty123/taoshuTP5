<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

use app\admin\validate\admin as adminValidate;

 class Admin extends Controller 
{
	public function index()
	{
		return $this->fetch('index');
	}

	public function updatePwdPage()
	{
		return $this->fetch('updatePwd');
	}

	public function updatePwd()
	{
		// dump($_POST);
		//1.获取数据
		$name = input('post.name');
		$pwd = input('post.pwd');
		$repwd = input('post.repwd');

		//2.验证数据
		//2.1构造验证数据
		$data = [
			'name'=>	$name,
			'pwd'	=>	$pwd,
			'repwd'	=>	$repwd
		];
		// dump($data);

		//2.2创建验证器实例
		$adminValidate = new adminValidate();

		//2.3验证数据，返回boolean
		$result = $adminValidate->scene('edit')->check($data);

		//2.4验证失败输出错误信息
		if(true !== $result){
		    // 验证失败 输出错误信息
		    // dump($result);
		    $this->error($adminValidate->getError());
		}

		//2.5验证成功
		// $this->success('验证成功！');

		//3.更新数据库
		//3.1拼装where条件
		$name = session('admin_name');
		$name = md5($name);
		$where = "name='{$name}' and pwd='{$name}'";
		//3.2查询数据库
		$ret = Db::table('admin')->where($where)->find();
		//3.3不存在该用户则报错
		if($ret == false)
		{
			$this->error('原始密码不正确！');
		}
		//3.4修改密码
		$where = "name = '{$name}'";
		$pwd = md5($pwd);
		$ret = Db::table('admin')->where($where)->update(["pwd"=>$pwd]);

		if ($ret == false) {
			$this->error('修改密码错误！');
		}

		//4.后续操作
		$this->success("修改密码成功", '/admin/index/index');
	}

	public function addPage()
	{
		return $this->fetch('adminAdd');
	}
	//添加新管理员
	public function adminAdd()
	{
		// dump($_POST);
		//1.获取数据
		$name = input('post.name');
		$pwd = input('post.pwd');
		$repwd = input('post.repwd');

		//2.验证数据
		//2.1构造验证数据
		$check = [
			'name'  =>	$name,
			'pwd'	=>	$pwd,
			'repwd'	=>	$repwd
		];
		// dump($check);

		//2.2创建验证器实例
		$adminValidate = new adminValidate();

		//2.3验证数据，返回boolean
		$result = $adminValidate->scene('add')->check($check);

		//2.4验证失败输出错误信息
		if(true !== $result){
		    // 验证失败 输出错误信息
		    // dump($result);
		    $this->error($adminValidate->getError());
		}

		//2.5验证成功
		// $this->success('验证成功！');

		//3.更新数据库
		//3.1拼装where条件
		$where = "name = '{$name}'";
		$data = [
			'name'  =>	$name,
			'pwd'	=>	md5($pwd),
			'last_time' => time()
		];
		//3.2添加管理员
		$ret = Db::table('admin')->where($where)->insert($data);

		if ($ret == false) {
			$this->error('添加管理员错误！', '/admin/index/index');
		}

		//4.后续操作
		$this->success("添加管理员成功！", '/admin/index/index');
	}
}