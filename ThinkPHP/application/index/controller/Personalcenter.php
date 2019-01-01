<?php
namespace app\index\controller;
use \think\Controller;

class Personalcenter extends \think\Controller
{
    public function index()
    {
    	 if(session('username')==NULL){
            $this->redirect('/index/login/index');
        }   
        return view('center');
    }

    //显示个人中心的编辑修改页面
    public function edit(){

    	$sid = session('userid');
        $ret = db('user')->where("user_id={$sid}")->find();
        $class = db('class')->select();
        $this->assign('ret',$ret);
        $this->assign('class',$class);
        return view('center');

    }

    //更新个人信息
    public function  update(){


    	 $sid = session('userid');
    	 $nickname = $_POST['nickname'];
    	 $realname = $_POST['realname'];
    	 $sex = $_POST['sex'];
    	 $grade = $_POST['grade'];
    	 $class1 = $_POST['class1'];
    	 $addr = $_POST['addr'];
    	 $tel = $_POST['tel'];
    	 $content = $_POST['content'];
    	 
    	 $data= [
    	 		'user_sex'=>$sex,
    	 		'nickname'=>$nickname,
				'user_realname'=>$realname,
				'grade'=>$grade,
				'class_id'=>$class1,
				'user_addr'=>$addr,
				'user_tel'=>$tel,
				'user_content'=>$content

    	 ];

	    	 $ret = db('user')->where("user_id={$sid}")->update($data);


	        if($ret==true){
	        $this->success("修改成功",'/index/personalcenter/edit');
	        }else{
	            $this->error("修改失败",'/index/personalcenter/edit');
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
   //上传个人头像
   public function uploadimg(){

				   	$sid = session('userid');
				   	$imgsave = input('post.imgsave');

				   	$data = [

				   		'user_img'=>$imgsave
				   ];

				   	$ret = db('user')->where("user_id={$sid}")->update($data);
				
				 if($ret==true){
				 	 session('user_img',$imgsave);
					$this->success("保存成功",'/index/personalcenter/edit');
					}else{
						$this->error("保存失败",'/index/personalcenter/edit');
						}
   }

   
}