<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

use app\admin\validate\admin as adminValidate;

 class Login extends Controller 
{
	//登录界面
	public function index()
	{
		return $this->fetch('login');
	}

	//登录验证
	public function login()
	{

		//1.获取登录表单数据
		$name = input('post.name');
		$pwd = input('post.pwd');

		//2.验证数据
		//2.1构造验证数据
		$data = [
			'name'	=>	$name,
			'pwd'	=>	$pwd
		];

		//2.2创建验证器实例
		$adminValidate = new adminValidate();

		//2.3验证数据，返回boolean
		$result = $adminValidate->check($data);

		//2.4验证失败输出错误信息
		if(true !== $result){
		    // 验证失败 输出错误信息
		    // dump($result);
		    $this->error($adminValidate->getError());
		}

		//2.5验证成功
		// $this->success('验证成功！');

		//3.查询数据库
		//3.1拼装where条件
		$pwd = md5($pwd);
		$where = "name='{$name}' and pwd='{$pwd}'";
		//3.2查询数据库
		$ret = Db::table('admin')->where($where)->find();
		//3.3不存在该用户则报错
		if($ret == false)
		{
			$this->error('用户名或密码不正确！');
		}

		//4.后续操作
		session('admin_name', $name);
		$this->success('登录成功');

	}


}