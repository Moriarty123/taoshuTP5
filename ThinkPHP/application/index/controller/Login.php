<?php
namespace app\index\controller;
use \think\Controller;

class Login extends \think\Controller
{
    public function index()
    {   
        $this->assign('Sensitivewords',0);
        return view('index');
    }
    //登录
    public function login(){

    	$username = $_POST['username'];
    	$pwd =$_POST['password'];
    	$password = md5($pwd);
    	$ret = db('user')->where("user_name='{$username}' and user_pwd='{$password}'")->find();
        $res = db('user')->where("user_name='{$username}'")->find();
        
        //判断用户是否已经被封号
        if ($res['Sensitivewords']==1) {
            $this->assign('Sensitivewords',$res['Sensitivewords']);
            return view('index');
        }
        //判断密码是不是输入错误三次
        if($res['error_state']==1){
            if(time()-$res['login_error_time']<300){
                $a=300-time()+$res['login_error_time'];
                $this->error("请".$a."秒后再登录",'/index/login/index');
            }else{
                $res['error_state']=0;
                 db('user')->where("user_id={$res['user_id']}")->update($res);
            }
        }
    	if($ret==true){
            session('userid',$ret['user_id']);       
            //放在success（）之前，不然登录成功直接跳走不执行储存
            session('username',$ret['user_name']);
            session('user_realname',$ret['user_realname']);
            session('user_img',$ret['user_img']);
            session('logintime',time());
            $res['login_error']=0;
            db('user')->where("user_id={$res['user_id']}")->update($res);
    		$this->success("登录成功",'/index/index/index');
           
    	}else{
            if($res['login_error']>=2){
                $res['login_error_time']=time();
                $res['error_state']=1;
                $res['login_error']=0;
                db('user')->where("user_id={$res['user_id']}")->update($res);
                $this->error("密码错误3次以上，请5分钟后再登录",'/index/login/index');

            }else{
                   if($res==true){
                    $res['login_error']+=1;
                    db('user')->where("user_id={$res['user_id']}")->update($res);

                    $this->error("用户名与密码不匹配",'/index/login/index');}
                    else{
                        $this->error("用户名与密码不匹配",'/index/login/index');}
                    }
            }
        }
    }
    //退出登录
    public function logout(){
         session('username',NULL);
         session('userid',NULL);
         $this->error('退出登录','/index/index/index');
    }

}