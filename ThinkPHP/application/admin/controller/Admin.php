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
		$prepwd = input('post.prepwd');
		$pwd = input('post.pwd');
		$repwd = input('post.repwd');

		//2.验证数据
		//2.1构造验证数据
		$data = [
			'prepwd'=>	$prepwd,
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
		$prepwd = md5($prepwd);
		$where = "name='{$name}' and pwd='{$prepwd}'";
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


}