<?php
namespace app\index\controller;
use \think\Controller;

class Personalsalecenter extends \think\Controller
{
    public function index(){

    	 if(session('username')==NULL){
            $this->redirect('/index/login/index');
        }   

    	$user_id = $_GET['id'];

    	//用户
    	$res = db('user')->alias('a')
                ->join('class b',"a.class_id = b.class_id and user_id={$user_id}")
                ->field('a.*,b.class_name')->find();

    	$this->assign('res',$res);

    	$ret = db('sale_book')->where("user_id={$user_id}")->select();
        
    	$this->assign('ret',$ret);

    	$rew = db('inquiry_book')->where("user_id={$user_id}")->select();
    	$this->assign('rew',$rew);
    	return view('personalsalecenter');
    }
}