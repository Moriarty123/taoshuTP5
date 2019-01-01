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

            $where = "user_id= $id";

     		$ret = db('user')->where($where)->update($data);
     		if($ret==true){
     			$this->success("修改密码成功",'index/index/index');
     		}else{
     			$this->error("修改密码失败",'index/index/index');
     		}

    }
}