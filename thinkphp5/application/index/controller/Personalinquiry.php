<?php
namespace app\index\controller;
use \think\Controller;

class Personalinquiry extends \think\Controller
{
	//个人中心求购书籍列表
    public function index(){

    	$sid = session('userid');
        $ret = db('inquiry_book')->where("user_id={$sid}")->select();
        $this->assign('ret',$ret);

        return view('inquiry');
    }
}