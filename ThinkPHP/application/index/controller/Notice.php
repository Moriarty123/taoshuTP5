<?php 

namespace app\index\controller; 

use think\Controller;
use think\Db;

class Notice extends Controller 
{
	//显示公告的详情
	public function index() 

		{
			$sid = $_GET['id'];
			$notice = db('notice')->alias('a')
					->join('admin b',"a.notice_id={$sid} and a.admin_id=b.id")
					->field('a.*,b.name')
					->select();

			foreach ($notice as $key => $value) {
				session('notice_title',$value['notice_title']);
			}
			
			$this->assign('notice',$notice);
			return view('notice');
			
		}


}
