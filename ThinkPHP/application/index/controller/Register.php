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

        // dump($_POST);
    	$username = $_POST['username'];
    	$pwd =$_POST['password'];
    	$password = md5($pwd);
        $user = db('user')->where("user_name='{$username}'")->find();
        if($user ==true){

            $this->success("用户名已被使用",'/index/login/index');

        }
        $data = [
            'user_name' => $username,
            'user_pwd' => $password
        ]; 

        // dump($data);
        $ret = db('user')->insert($data);
        if($ret==true){
          $this->success("注册成功",'/index/login/index');
      }else{
         $this->error("注册失败",'/index/register/index');
     }

 }
}