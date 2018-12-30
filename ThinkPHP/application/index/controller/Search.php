<?php
namespace app\index\controller;

use think\Db;
use think\Controller;

class Search extends Controller
{
	//搜索求购书籍
    public function searchinquiry(){

    	$keyword = input('keyword');
    	if ($keyword=="") {
    		$this->assign('keyword',$keyword);
    		return view('searchinquiry_no_key');
    	}
    	$ret=Db::table('inquiry_book')->where('inquiry_name|inquiry_author','like',"%$keyword%")->alias('a')
            ->join('user b',"b.user_id=a.user_id")
            ->join('class c',"c.class_id=b.class_id")
            ->join('dept d',"c.dept_id=d.dept_id")
            ->field('a.*,b.user_realname,b.grade,c.class_name,d.dept_name')
            ->paginate(5);
    	
    	$this->assign('keyword',$keyword);
    	$this->assign('ret',$ret);
    	if (count($ret)) {
    		return view('searchinquiry_yes');
    	}else{
    		return view('searchinquiry_no');
    	}
    	
    }

    //搜索出售书籍
    public function searchsale(){

    	$keyword = input('keyword');

    	if ($keyword=="") {
    		$this->assign('keyword',$keyword);
    		return view('searchsale_no_key');
    	}
    	
    	$res=Db::table('sale_book')
                ->where('sale_name|sale_author','like',"%$keyword%")
                ->alias('a')
                ->join('user b',"b.user_id=a.user_id")
                ->order('sale_time','desc')
                ->field('a.*,b.user_realname,b.user_id')
                ->paginate(10);
        //最蠢的办法
        $rew = db('shoporder')->where("order_state=1")->group('book_id')
                ->field('sum(order_sum) as a,book_id')->select();
        $data = [];
        foreach ($res as $value) {
            foreach ($rew as $va) {
                if($value['sale_id'] ==$va['book_id']){
                    $data[]=$va['book_id'];
                }
            }  
        }
         $this->assign('data',$data);
        $this->assign('rew',$rew);
        $lengh = count($res);
        $wantsearch = [];
        if ($lengh>5) {
           for($i=0;$i<5;$i++){
            $wantsearch[]=$res[$lengh-$i-1]['sale_name'];
            }
        }else{
            for($i=0;$i<$lengh;$i++){
            $wantsearch[]=$res[$lengh-$i-1]['sale_name'];
            }
        }
        $this->assign('keyword',$keyword);
    	$this->assign('wantsearch',$wantsearch);
    	$this->assign('res',$res);
    	if (count($res)) {
    		return view('searchsale_yes');
    	}else{
    		return view('searchsale_no');
    	}   	
    }

    //按照价格、库存、新旧程度排序
    public function orderbyprice(){

            //获取数据
                $keyword = input('keyword');
                $type = $_GET['type'];
                $controll = $_GET['control'];

                    //判断搜索内容是否为空
                if ($keyword=="") {
                    $this->assign('keyword',$keyword);
                    return view('searchsale_no_key');
                }
                 //模糊搜索
                    $res=Db::table('sale_book')
                    ->where('sale_name|sale_author','like',"%$keyword%")
                    ->alias('a')
                    ->join('user b',"b.user_id=a.user_id")
                    ->order("{$controll}","{$type}")
                    ->field('a.*,b.user_realname,b.user_id')
                    ->paginate(10);
                   
                //最蠢的办法
                $rew = db('shoporder')
                        ->where("order_state=1")
                        ->group('book_id')
                        ->field('sum(order_sum) as a,book_id')
                        ->select();
                    //选出两个表的共同字段，搜索商品，而这里订单表没有的商品销售量为零
                    //本来想建多一个销量表存储数据的
                    $data = [];
                    foreach ($res as $value) {
                        foreach ($rew as $va) {
                            if($value['sale_id'] ==$va['book_id']){
                                $data[]=$va['book_id'];
                            }
                        }  
                    }
                    //传输数据给页面
                    $this->assign('data',$data);
                    $this->assign('rew',$rew);

                    //循环输出5个（如果搜索出来内容不足5个，则为所有内容名字）sale_name作为
                    //提示用户想要搜索的内容
                    $lengh = count($res);
                    $wantsearch = [];
                    if ($lengh>5) {
                       for($i=0;$i<5;$i++){
                        $wantsearch[]=$res[$lengh-$i-1]['sale_name'];
                        }
                    }else{
                        for($i=0;$i<$lengh;$i++){
                        $wantsearch[]=$res[$lengh-$i-1]['sale_name'];
                        }
                    }
                    $this->assign('keyword',$keyword);
                    $this->assign('wantsearch',$wantsearch);
                    $this->assign('res',$res); 
                    //判断是否搜索到内容
                    if (count($res)) {
                        return view('searchsale_yes');
                    }else{
                        return view('searchsale_no');
                    }       
    }

    //综合排序->实际上我是按照该书籍的评论热度进行排序的
    public function orderbycomprehensive(){

            $keyword = input('keyword');

            if ($keyword=="") {
                $this->assign('keyword',$keyword);
                return view('searchsale_no_key');
            }
            
            $res=Db::table('sale_book')
                    ->where('sale_name|sale_author','like',"%$keyword%")
                    ->alias('a')
                    ->join('user b',"b.user_id=a.user_id")
                    ->order('sale_time','desc')
                    ->field('a.*,b.user_realname,b.user_id')
                    ->paginate(10);
            //最蠢的办法
            $rew = db('shoporder')
                ->where("order_state=1")
                ->group('book_id')
                ->field('sum(order_sum) as a,book_id')
                ->select();

            $rep = db('bcomment')->group('bbook_id')
                    ->field('sum(b_num) as a,bbook_id')->select();
                    // dump($rew);die;
            $data = [];
            $base =[];
            $baseall = [];
            foreach ($res as $value) {
                foreach ($rew as $va) {
                   
                    if($value['sale_id'] ==$va['book_id']){

                        $data[]=$va['book_id'];
                        $value['xiaoliang'] = $va['a']; 
                         
                    }else{
                        $value['xiaoliang'] = 0; 
                    }
                }  
                $base[]=$value;
            }

            foreach ($base as $value) {
                foreach ($rep as $va) {
                   
                    if( $va['bbook_id']==$value['sale_id']){

                        $value['plliang'] = $va['a']; 
                         
                    }
                }  
                $baseall[]=$value;
            }
            // dump($baseall);die;
            //通过二维数组的排列实现销量排行，stupid function
            foreach ($baseall as $key => $row)
            {
                $volume[$key]  = $row['plliang'];
            }

             array_multisort($volume, SORT_DESC,$base);
            
             $this->assign('data',$data);
            $this->assign('rew',$rew);
            $lengh = count($res);
            $wantsearch = [];
            if ($lengh>5) {
               for($i=0;$i<5;$i++){
                $wantsearch[]=$res[$lengh-$i-1]['sale_name'];
                }
            }else{
                for($i=0;$i<$lengh;$i++){
                $wantsearch[]=$res[$lengh-$i-1]['sale_name'];
                }
            }
            $this->assign('keyword',$keyword);
            $this->assign('wantsearch',$wantsearch);
            $this->assign('res',$base);

            if (count($res)) {
                return view('searchsale_yes');
            }else{
                return view('searchsale_no');
            }       
        
    }

    //按照销量排序
    public function orderbysalesum(){

           $keyword = input('keyword');

            if ($keyword=="") {
                $this->assign('keyword',$keyword);
                return view('searchsale_no_key');
            }
            
            $res=Db::table('sale_book')
                    ->where('sale_name|sale_author','like',"%$keyword%")
                    ->alias('a')
                    ->join('user b',"b.user_id=a.user_id")
                    ->order('sale_time','desc')
                    ->field('a.*,b.user_realname,b.user_id')
                    ->paginate(10);
            //最蠢的办法
            $rew = db('shoporder')->where("order_state=1")->group('book_id')
                    ->field('sum(order_sum) as a,book_id')->select();
            $data = [];
            $base =[];
            foreach ($res as $value) {
                foreach ($rew as $va) {
                    if($value['sale_id'] ==$va['book_id']){

                        $data[]=$va['book_id'];
                        $value['xiaoliang'] = $va['a']; 

                    }else{
                        $value['xiaoliang'] = 0; 
                    }
                }  
                $base[]=$value;
            }
            //通过二维数组的排列实现销量排行，stupid function
            foreach ($base as $key => $row)
            {
                $volume[$key]  = $row['xiaoliang'];
            }

             array_multisort($volume, SORT_DESC,$base);
            
             $this->assign('data',$data);
            $this->assign('rew',$rew);
            $lengh = count($res);
            $wantsearch = [];
            if ($lengh>5) {
               for($i=0;$i<5;$i++){
                $wantsearch[]=$res[$lengh-$i-1]['sale_name'];
                }
            }else{
                for($i=0;$i<$lengh;$i++){
                $wantsearch[]=$res[$lengh-$i-1]['sale_name'];
                }
            }
            $this->assign('keyword',$keyword);
            $this->assign('wantsearch',$wantsearch);
            $this->assign('res',$base);

            if (count($res)) {
                return view('searchsale_yes');
            }else{
                return view('searchsale_no');
            }       
        
        }

}