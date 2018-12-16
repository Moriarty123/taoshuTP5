<?php

namespace app\index\model;

use think\Controller;
use think\Db;

class index extends Controller
{
	function GetAllBookType(){
		$sql = "select * from book_type limit 0,8;";
		// $data = db('book_type')->limit(8)->select($sql);
		$data = Db::query($sql);
		// dump($data);
		return $data;
	}
	function GetTypeSecond_jj(){	// 获取前5个经济金融
		$sql = "select * from type_second where type_id=1 limit 0,5;";
		// $data = db('type_second')->limit(5)->select($sql);
		$data = Db::query($sql);
		// dump($data);
		return $data;
	}
	function GetTypeSecond_jsj(){ 	// 获取前5个计算机与网络
		$sql = "select * from type_second where type_id=2 limit 0,5;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetTypeSecond_gl(){
		$sql = "select * from type_second where type_id=3 limit 0,6;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetTypeSecond_yy(){
		$sql = "select * from type_second where type_id=4 limit 0,8;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetTypeSecond_wx(){
		$sql = "select * from type_second where type_id=5 limit 0,6;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetTypeSecond_yx(){
		$sql = "select * from type_second where type_id=6 limit 0,8;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetTypeSecond_jy(){
		$sql = "select * from type_second where type_id=7 limit 0,5;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	
	// 获取全部经济金融
	function GetAllTypeSecond_jj(){	
		$sql = "select * from type_second where type_id=1;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetAllTypeSecond_jsj(){ 	
		$sql = "select * from type_second where type_id=2;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetAllTypeSecond_gl(){
		$sql = "select * from type_second where type_id=3;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetAllTypeSecond_yy(){
		$sql = "select * from type_second where type_id=4;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetAllTypeSecond_wx(){
		$sql = "select * from type_second where type_id=5;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetAllTypeSecond_yx(){
		$sql = "select * from type_second where type_id=6;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	function GetAllTypeSecond_jy(){
		$sql = "select * from type_second where type_id=7;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	
	function GetNewSaleBook(){
		$sql = "select * from sale_book where sale_state = 0 order by sale_time desc limit 0,10;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	
	function GetNotice(){
		$sql = "select * from notice order by notice_time desc";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
	
	function GetNewInquiry(){
		$sql = "select * from inquiry_book where inquiry_state = 0 order by inquiry_time desc limit 0,10;";
		// $data = $this->_dao->GetRows($sql);
		$data = Db::query($sql);
		return $data;
	}
}
?>