<?php
namespace app\index\controller;
use \think\Controller;

class Personalsale extends \think\Controller
{
	//个人中心出售书籍列表
    public function index()
    {
    	$sid = session('userid');
        $ret = db('sale_book')->where("user_id={$sid}")->select();
   
        $this->assign('ret',$ret);

        return view('sale');
    }
}