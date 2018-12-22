<?php 

namespace app\index\controller; 

use think\Controller;
use think\Db;

class Inquire extends Controller 
{
	//显示所有求购书籍
	public function showAllInquireBook() 
	{

		$ret = Db::name('inquiry_book')->paginate(5);

		$this->assign('inquireBookList', $ret);

		return $this->fetch('showAllInquireBook');
	}


}


