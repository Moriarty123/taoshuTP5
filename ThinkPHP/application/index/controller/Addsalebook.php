<?php
namespace app\index\controller;
use \think\Controller;

class Addsalebook extends \think\Controller
{
    public function index()
    {	
       
        if(session('username')==NULL){
             $this->redirect('/index/login/index');
        }   
    	$ret = db('type_second')->select();
    	$this->assign('ret',$ret);
        return view('addsalebook');
    }

    public function insert(){


             $sale_new=[
                '全新'  => 10,
                '九成新'=>9,
                '八成新'=>8,
                '七成新'=>7,
                '六成新及以下'=>6
            ];

    	$sid = session('userid');
    	$addtime = time();
    	
    	$isbn = input('isbn','','htmlspecialchars');
    	$name = input('name','','htmlspecialchars');
    	$author = input('author','','htmlspecialchars');
    	$publishing = input('publishing','','htmlspecialchars');
    	$beprice = input('beprice','','htmlspecialchars');
    	$afprice = input('afprice','','htmlspecialchars');
    	$num = input('num','','htmlspecialchars');
    	$page = input('page','','htmlspecialchars');
    	$degrees = input('degrees','','htmlspecialchars');
        $new = $sale_new["{$degrees}"];
    	$type = input('type','','htmlspecialchars');
    	$content = input('content','','htmlspecialchars');

    	
    	$imgsave = $_POST['imgsave'];
       
    	// var_dump($imgsave);die;
    	$data=[
    		'sale_isbn'=>$isbn,
    		'sale_name'=>$name,
    		'sale_author'=>$author,
    		'sale_publishing'=>$publishing,
    		'sale_beprice'=>$beprice,
    		'sale_afprice'=>$afprice,
    		'sale_num'=>$num,
    		'sale_page'=>$page,
    		'sale_degrees'=>$degrees,
    		'sale_secondtype'=>$type,
    		'sale_content'=>$content,
    		'sale_img'=>$imgsave,
    		'user_id'=>$sid,
    		'sale_time'=>$addtime,
            'sale_new'=>$new
    	];
    	$ret= db('sale_book')->insert($data);
    	if($ret==true){
		$this->success("保存成功",'/index/index/index');
		}else{
			$this->error("保存失败",'/index/addsalebook/index');
			}

    }
     public function upimg(){

		  // 获取表单上传文件 例如上传了001.jpg
			    $file = request()->file('image');
			    
			    // 移动到框架应用根目录/public/uploads/ 目录下
			    if($file){
			        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
			        if($info){
			            // 成功上传后 获取上传信息
			            // 输出 jpg
			            // echo $info->getExtension();
			            // // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
			         	$imgsave ="/uploads/{$info->getSaveName()}";
			     		echo $imgsave;
			            // // 输出 42a79759f284b767dfcb2a0197904287.jpg
			            // echo $info->getFilename(); 
			        }else{
			            // 上传失败获取错误信息
			            echo $this->error($file->getError());
				        }
				    }

   }

}