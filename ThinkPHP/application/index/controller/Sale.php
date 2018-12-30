<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

class Sale extends Controller 
{
	//显示所有出售书籍
	function showAllSaleBook() {

		$ret = Db::name('sale_book')->paginate(5);

		$this->assign('saleBookList', $ret);

		return $this->fetch('showAllSaleBook');

	}

	//显示二级分类列表下的书籍列表
	public function classdetail(){
		$second_name = $_GET['second_name'];
		session('second_name',$second_name);
		$res = db('type_second')->alias('a')->join('book_type b',"a.second_name='{$second_name}' and b.type_id = a.type_id")->field('a.second_id,b.type_name,b.type_id')->find();
		$sid = $res['second_id'];
		session('first_type',$res['type_name']);
		session('type_id',$res['type_id']);
		$res = db('type_second')->where("type_id={$res['type_id']}")->select();
		$this->assign('res',$res);
        // dump($res);die;
		// dump($sid);die;
		$ret = db('sale_book')->alias('a')->join('user b',"a.user_id = b.user_id and a.sale_secondtype = {$sid}")->join('class c',"b.class_id=c.class_id")->join('dept d',"c.dept_id = d.dept_id")->field('a.*,b.user_realname,b.nickname,b.grade,c.class_name,d.dept_name')->select();
		$this->assign('ret',$ret);
		// dump($ret);die;
		
		return view('classdetail');
	}
   
     //进入出售书籍的详情页面
   public function saledetail(){
	   		$sid =$_GET['id'];
	   		// dump($sid);die;
	   		$userid = session('userid');
	   		//寻找详细书籍信息
	   		$ret = db('sale_book')->alias('a')
		   		->join('type_second b',"a.sale_secondtype=b.second_id and a.sale_id={$sid}")
		   		->join('book_type c',"b.type_id=c.type_id")->join('user e',"a.user_id=e.user_id")
		   		->field('a.*,b.second_name,b.second_id,c.type_name,e.user_realname')
		   		->find();
	   		$this->assign('ret',$ret);

	   		
	   		//寻找评论表
	   		$res = db('bcomment')->alias('a')->join('user b',"bbook_id={$ret['sale_id']} and a.user_id = b.user_id")->field('a.*,b.*')->select();
	   		
	   		
	   		foreach ($res as $key => $value) {
	   			$bcomm = db('bcomment_reply_dianzan')->where("bcomment_id={$value['bcomment_id']} and dianzan_num =1")->select();
	   			$a=count($bcomm);
	   			$res[$key]['dzsum']=$a;
	   		}
	   		$this->assign('res',$res);

	   		//寻找回复评论表
	   		$rew = db('bcomment')->alias('a')
	   		->join('bcomment_reply b',"a.bcomment_id=b.comment_id and bbook_id={$ret['sale_id']}")
	   		->join('user c',"c.user_id=b.user_id")
	   		->select();
	   		

	   		$this->assign('rew',$rew);
	   		$this->assign('reply',$rew);

	   		

	   		return view('saledetail');

   }
    //判断评论内容是否含有色情、反动、贪腐、暴恐等词汇
   public function Sensitivewords($content,$sale_id){
   				$user_id = session('userid');
   				//判断是否有色情词汇
			   	if (is_file("./static/Sensitivewords/porn.txt")){  

	       			 $filter_word = file("./static/Sensitivewords/porn.txt");
	       			 // dump($filter_word);die;     
	       			for($i=0;$i<count($filter_word);$i++){    

	       			 if(preg_match("/".trim($filter_word[$i])."/i",$content)){

	       			 		$data=[
	       			 			'user_id'=>$user_id,
	       			 			'content'=>$content,
	       			 			'addtime'=>time()
	       			 		];
	       			 		db('Sensitivewords')->insert($data);
	       			 		//违规，强迫下线
	       			 		$ret = db('Sensitivewords')->where("user_id={$user_id}")->select();
	       			 		if(count($ret)>=5){
	       			 		$res = db('user')->where("user_id={$user_id}")->find();
	       			 		$res['Sensitivewords'] = 1;
	       			 		 db('user')->where("user_id={$user_id}")->update($res);
	       			 			$this->error('你已被封号，即将强制下线','/index/login/logout');
	       			 		}
							  
							  $this->error('请不要发表色情敏感词，5次以上将封号',"/index/sale/saledetail?id={$sale_id}");
							  }			     
			        	}  
			   		 }
			   		 //判断是否有贪腐词汇
			   		 if (is_file("./static/Sensitivewords/Corruption.txt")){  

	       			 $filter_word = file("./static/Sensitivewords/Corruption.txt");
	       			 // dump($filter_word);die;     
	       			for($i=0;$i<count($filter_word);$i++){    

	       			 if(preg_match("/".trim($filter_word[$i])."/i",$content)){

	       			 		$data=[
	       			 			'user_id'=>$user_id,
	       			 			'content'=>$content,
	       			 			'addtime'=>time()
	       			 		];
	       			 		db('Sensitivewords')->insert($data);
	       			 		//违规，强迫下线
	       			 		$ret = db('Sensitivewords')->where("user_id={$user_id}")->select();
	       			 		if(count($ret)>=5){
	       			 			$this->error('你已被封号，即将强制下线','/index/login/logout');
	       			 		}
							  
							  $this->error('请不要发表贪腐敏感词，5次以上将封号',"/index/sale/saledetail?id={$sale_id}");
							  }			     
			        	}  
			   		 }
			   		 //判断是否有反动词汇
			   		 if (is_file("./static/Sensitivewords/reactionary.txt")){  

	       			 $filter_word = file("./static/Sensitivewords/reactionary.txt");
	       			 // dump($filter_word);die;     
	       			for($i=0;$i<count($filter_word);$i++){    

	       			 if(preg_match("/".trim($filter_word[$i])."/i",$content)){
		       			 	$data=[
		       			 			'user_id'=>$user_id,
		       			 			'content'=>$content,
		       			 			'addtime'=>time()
		       			 		];
		       			 		db('Sensitivewords')->insert($data);
		       			 		//违规，强迫下线
	       			 		$ret = db('Sensitivewords')->where("user_id={$user_id}")->select();
	       			 		if(count($ret)>=5){
	       			 			$this->error('你已被封号，即将强制下线','/index/login/logout');
	       			 		}
								  
							  $this->error('请不要发表反动敏感词，5次以上将封号',"/index/sale/saledetail?id={$sale_id}");
							  }			     
			        	}  
			   		 }
			   		 if (is_file("./static/Sensitivewords/Violence.txt")){  

	       			 $filter_word = file("./static/Sensitivewords/Violence.txt");
	       			 // dump($filter_word);die;     
	       			for($i=0;$i<count($filter_word);$i++){    

	       			 if(preg_match("/".trim($filter_word[$i])."/i",$content)){
		       			 	$data=[
		       			 			'user_id'=>$user_id,
		       			 			'content'=>$content,
		       			 			'addtime'=>time()
		       			 		];
		       			 		db('Sensitivewords')->insert($data);
		       			 		//违规，强迫下线
	       			 		$ret = db('Sensitivewords')->where("user_id={$user_id}")->select();
	       			 		if(count($ret)>=5){
	       			 			$this->error('你已被封号，即将强制下线','/index/login/logout');
	       			 		}
							  
							  $this->error('请不要发表暴恐敏感词，5次以上将封号',"/index/sale/saledetail?id={$sale_id}");
							  }			     
			        	}  
			   		 }

			   		 return true;

   }
   //发表评论
   public function postmsg(){

		   		 if(session('username')==NULL){
		            $this->redirect('/index/login/index');
		       		 }	
			   		$content = input('content');
			   		$sale_id = input('book_id');
			   		
			   		$user_id = session('userid');
			   		$comment_time = time();
			   		$this->Sensitivewords($content,$sale_id);
			   		$data=[

			   				'bcomment_content'=>$content,
			   				'user_id'=>$user_id,
			   				'bbook_id'=>$sale_id,
			   				'bcomment_time'=>$comment_time

			   		];

			   		$ret = db('bcomment')->insert($data);
			   		if ($ret==true) {
			   			$this->success('发表成功');
			   		}else{
			   			$this->error('发表成功');
			   		}
   	
   }

   //出售书籍点赞数统计
   public function dianzan(){
   		//判断是否登录
   		 if(session('username')==NULL){
           $this->redirect('/index/login/index');
       	 }	

		   	   $bcomment_id = $_GET['ids'];
		   	   $user_id =session('userid');

		   	   $res = db('bcomment')->where("bcomment_id={$bcomment_id}")->find();
		   	   $sale_id = $res['bbook_id'];

		   	   $ret = db('bcomment_reply_dianzan')->where("bcomment_id={$bcomment_id}")->select();
		   	   $ids = [];
		   	   foreach ($ret as $key => $value) {
		   	      $ids[] = $value['user_id'];
		   	   }
		   	   if ($ret==true) { 
		   	   	if(in_array($user_id,$ids)){

		   	   		$res=db('bcomment_reply_dianzan')->where("bcomment_id={$bcomment_id} and user_id={$user_id}")->find();

		   	   		if($res['state']==1){
		   	   			$res['state']=0;
		   	   			$res['dianzan_num']-=1;
		   	   			db('bcomment_reply_dianzan')->where("user_id={$user_id} and bcomment_id={$bcomment_id}")->update($res);
		   	   			$this->redirect("/index/sale/saledetail?id=$sale_id");
		   	   		}
		   	   		else{
		   	   			$res['state']=1;
		   	   			$res['dianzan_num']+=1;
		   	   			db('bcomment_reply_dianzan')->where("user_id={$user_id} and bcomment_id={$bcomment_id}")->update($res);
		   	   			$this->redirect("/index/sale/saledetail?id=$sale_id");
		   	   		}
		   	   	}else{
		   	   
				   	   	$data=[
				   	   		'user_id'=>$user_id,
				   	   		'bcomment_id'=>$bcomment_id,
				   	   		'dianzan_num'=>1,
				   	   		'state'=>1
				   	   	];
				   	   		db('bcomment_reply_dianzan')->insert($data);
				   	   		$this->redirect("/index/sale/saledetail?id=$sale_id");
		   	   	}
		   	   }
		   	   else{
		   	   	$a = 1;
		   	   	$data=[
		   	   		'user_id'=>$user_id,
		   	   		'bcomment_id'=>$bcomment_id,
		   	   		'dianzan_num'=>$a,
		   	   		'state'=>1
		   	   	];
		   	   		db('bcomment_reply_dianzan')->insert($data);
		   	   		$this->redirect("/index/sale/saledetail?id=$sale_id");
		   	   }	   	   
   }

   //添加回复评论
   public function pinlun(){

   		if(session('username')==NULL){
             $this->redirect('/index/login/index');
       	 }	

    	$sid = session('userid');
    	
    	$bcomment_id = input('post.hiddenzhi');
    	$content = input('data');
    	$addtime = time();
      
    	$data= [

    			'reply_content'=>$content,
    			'user_id'=>$sid,
    			'addtime'=>$addtime

    	];

        if($bcomment_id!=""){

                           $data['comment_id']=$bcomment_id;
                             // dump($data);die;
                           $ret = db('bcomment_reply')->insert($data);
                if($ret==false){

                                $this->success('评论失败','',2);

                }else{

                                 $this->error('评论成功');
                }

  			 }

	}

}
