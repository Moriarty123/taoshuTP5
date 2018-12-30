<?php 

namespace app\index\controller;

use think\Controller;
use think\Db;

class Type extends Controller
{
	public function showAllTypeSecond()
	{
		//以以下格式返回书籍类型
		//
	 	// '经济金融' => 
		//   [
		//     0 =>  '会计审计统计' 
		//     1 =>  '经济学理论' 
		//     2 =>  '国际贸易' 
		//     3 =>  '国际金融' 
		//     4 =>  '投资理财' 
		//     5 =>  '财经税收' 
		//     6 =>  '经济史' 
		//     7 =>  '世界经济' 
		//     8 =>  '中国经济' 
		//     9 =>  '工业经济' 
		//     10 => '银行与货币' 
		// ]


		//获取所有书籍类型
		$bookType = Db::table('book_type')->select();


		//封装数据格式
		$res = [];
		foreach ($bookType as $key => $value) {
			
			$typeSecond = Db::table('type_second')->field('second_id,second_name')->where("type_id={$value['type_id']}")->select();
           
			$temp = [];

			foreach ($typeSecond as $key => $second_name) {
				$temp[] = $second_name['second_name'];
			}


			$res[$value['type_name']] = $temp;

		}
		
		$this->assign('typeSecond', $res);

		return $this->fetch('showAllTypeSecond');
	}
}