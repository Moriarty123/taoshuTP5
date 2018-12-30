<?php
namespace app\index\controller;
use \think\Controller;

class Updatepwd extends \think\Controller
{
    public function index()
    {
        return view('updatepwd');
    }
     public function updatepwd(){
    		
    		$id = session('userid');
     		$prepwd = $_POST['prepwd'];
     		$newPwd = $_POST['newPwd'];
     		$prepwd2 = md5($prepwd);
     		$password = md5($newPwd);
     		$data = [
     			'user_pwd' =>$password
     		];

     		$ret = db('user')->where("user_pwd=$prepwd2")->update($data);
     		if($ret==true){
     			$this->success("修改密码成功",'index/updatepwd/index');
     		}else{
     			$this->error("修改密码失败",'index/updatepwd/index');
     		}

    }
}