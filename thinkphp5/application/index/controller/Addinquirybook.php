<?php
namespace app\index\controller;
use \think\Controller;

class Addinquirybook extends \think\Controller
{
    public function index()
    {	
         if(session('username')==NULL){
            $this->redirect('/index/login/index');
        }   
    	$ret = db('type_second')->select();
    	$this->assign('ret',$ret);
        return view('addinquirybook');
    }

    public function insert(){
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
    	$type = input('type','','htmlspecialchars');
    	$content = input('content','','htmlspecialchars');
    	$attach = input('attach','','htmlspecialchars');
    	$imgsave = $_POST['imgsave'];
    	// var_dump($imgsave);die;
    	$data=[
    		'inquiry_isbn'=>$isbn,
    		'inquiry_name'=>$name,
    		'inquiry_author'=>$author,
    		'inquiry_publishing'=>$publishing,
    		'inquiry_minprice'=>$beprice,
    		'inquiry_maxprice'=>$afprice,
    		'inquiry_num'=>$num,
    		'inquiry_page'=>$page,
    		'inquiry_degrees'=>$degrees,
    		'inquiry_secondtype'=>$type,
    		'inquiry_content'=>$content,
    		'inquiry_img'=>$imgsave,
    		'inquiry_attach'=>$attach,
    		'user_id'=>$sid,
    		'inquiry_time'=>$addtime
    	];
    	$ret= db('inquiry_book')->insert($data);
    	if($ret==true){
		$this->success("保存成功",'/index/index/index');
		}else{
			$this->error("保存失败",'/index/addinquirybook/index');
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