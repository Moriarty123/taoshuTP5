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
		$result = $adminValidate->scene('login')->check($data);

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
		//4.1存入session
		$count = $ret['times'];
		$admin_id = $ret['id'];
		session('admin_id', $admin_id);
		session('admin_name', $name);
		session('lastLoginTime', $ret['last_time']);
		session('loginTime', time());
		session('count', $count);
		//4.2页面传值
		// $count = $ret['times'];
		// $this->assign('lastLoginTime', $ret['last_time']);
		// $this->assign('count', $count);

		//4.3更新最后登录时间和登录次数
		$where = "id={$admin_id}";
		Db::table('admin')->where($where)->setInc('times',1);
		// $loginTime = date('Y-m-d H:i:s', time());
		$loginTime = time();
		Db::table('admin')->where($where)->setField('last_time', $loginTime);	


		// return $this->fetch('index/index');
		$this->success('登录成功', '/admin/index/index');//不能使用success，this->assign()失效

	}

	//退出登录
	public function logout()
	{
		session('admin_id', NULL);
		session('admin_name', NULL);
		
		$this->success('退出成功！', 'admin/index/index');
	}


}