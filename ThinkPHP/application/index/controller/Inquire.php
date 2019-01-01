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
	//显示详情页面
	public function inquirydetail(){

	   		$sid =$_GET['id'];
	   		
	   		$ret = db('inquiry_book')->alias('a')
			   		->join('user b',"a.inquiry_id={$sid} and a.user_id=b.user_id")
			   		->field('a.*,b.user_realname')
			   		->find();
	   		$this->assign('ret',$ret);

	   		

	   		$res = db('scomment')->alias('a')
	   		->join('user b',"sbook_id={$ret['inquiry_id']} and a.user_id = b.user_id")
	   		->field('a.*,b.*')->select();
	   		
	   		$this->assign('res',$res);
	   		return view('inquirydetail');

   }


   public function postmsg(){

		   		 if(session('username')==NULL){
		            $this->redirect('/index/login/index');
		        }	
		   		$content = input('content');
		   		$inquiry_id = input('book_id');
		   		
		   		$user_id = session('userid');
		   		$comment_time = time();

		   		$data=[

		   				'scomment_content'=>$content,
		   				'user_id'=>$user_id,
		   				'sbook_id'=>$inquiry_id,
		   				'scomment_time'=>$comment_time

		   		];

		   		$ret = db('scomment')->insert($data);
		   		if ($ret==true) {
		   			$this->success('发表成功');
		   		}else{
		   			$this->error('发表成功');
		   		}
		   	
   }


}


