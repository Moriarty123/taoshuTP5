<?php
namespace app\index\controller;
use \think\Controller;

class Register extends \think\Controller
{
    public function index()
    {
        return view('register');
    }
    //注册新用户
    public function insert(){

    	$username = $_POST['username'];
    	$pwd =$_POST['password'];
    	$password = md5($pwd);
        $username = db('user')->where("user_name='{$username}'")->find();
         if($username==true){

            $this->success("用户名已被使用",'/index/login/index');

        }
    	$data = [
    				'user_name' => $username,
    				'user_pwd' => $password
    			]; 
    	 $ret = db('user')->insert($data);
	    if($ret==true){
		$this->success("注册成功",'/index/login/index');
		}else{
			$this->error("注册失败",'/index/register/index');
			}

    }
}