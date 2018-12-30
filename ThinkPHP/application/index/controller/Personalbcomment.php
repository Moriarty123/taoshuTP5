<?php
namespace app\index\controller;
use \think\Controller;

class Personalbcomment extends \think\Controller
{
	//个人中心的出售留言页面
    public function index()
    {
    	$sid = session('userid');
        $ret = db('bcomment')->alias('a')
		        ->join('sale_book b',"a.user_id={$sid} and a.bbook_id=b.sale_id")
		        ->select();
   		
        $this->assign('ret',$ret);

        return view('bcomment');
    }
}
