<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use think\Controller;
use think\Db;
use think\Log;

class Carousel extends Common
{
	public function index()
	{
		return $this->fetch('index');
	}

	public function carouselList()
	{
		$carouselList = Db::table('carousel')->paginate(15);
		$carouselNumber = Db::table('carousel')->count();

		$this->assign('carouselList', $carouselList);
		$this->assign('carouselNumber', $carouselNumber);

		Log::record('显示轮播图列表','notice');

		return $this->fetch('carouselList');
	} 

	//改变状态
	public function changeState()
	{
		$carousel_id = input('get.carousel_id');

		$where = "carousel_id = {$carousel_id}";

		$ret = Db::table('carousel')->where($where)->update(['carousel_state' => 1]);

		if ($ret == false) {
			$this->error('修改状态失败！');
		}

		$this->success('修改状态成功！', '/admin/carousel/carouselList');
	}

	public function carouselEdit()
	{
		$carousel_id = input('get.carousel_id');

		$where = "carousel_id = {$carousel_id}";

		$carousel = Db::table('carousel')->where($where)->find();

		$carousel_state = $carousel['carousel_state'];

		$change = $carousel_state == 0? 1:0;

		$ret = Db::table('carousel')->where($where)->update(['carousel_state' => $change]);

		if ($ret == false) {
			$this->error('修改状态失败！');
		}

		$this->success('修改状态成功！', '/admin/carousel/carouselList');
	}

	//模糊查找
	public function carouselSearch()
	{
		// dump($_POST);
		$search = input('post.search');

		if(!empty($search)) {
			session('carouselsearch', $search);
			$where['carousel_img'] = array('like','%'.$search.'%');//封装模糊查询 赋值到数组	
		}
		else 
		{
			$search = session('carouselsearch');
			$where['carousel_img'] = array('like','%'.$search.'%');	
		}
		// dump();
		
		//获取订单
		$carousel = Db::table('carousel')
		->where($where)
		->paginate(15);

		$carouselNumber = Db::table('carousel')
		->where($where)
		->count();

		$this->assign('carouselList', $carousel);
		$this->assign('carouselNumber', $carouselNumber);

		return $this->fetch('carouselList');

	}

	//删除订单
	public function carouselDelete()
	{
		// dump($_GET);
		$carousel_id = input('get.carousel_id');
		$where = "carousel_id = {$carousel_id}";

		//暂时取消外链，删除后恢复
		Db::query('SET FOREIGN_KEY_CHECKS = 0;');
		$ret = Db::table('carousel')->where($where)->delete();
		Db::query('SET FOREIGN_KEY_CHECKS = 1;');

		if ($ret == false) {
			$this->error('删除失败！');
		}

		$this->success('删除成功！', '/admin/carousel/carouselList');
	}
	
	//批量删除
	public function checkedcarouselDelete()
	{
		// dump($_POST);
		//TP5的post方法不能提交数组，在表单name添加/a表示要提交有关数组，获取时同样要添加/a
		$ids = input('post.ids/a');
		// dump($ids);
		// $count = count($ids);

		foreach ($ids as $key => $id) {
			$where = "carousel_id = {$id}";
			//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('shopcarousel')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');
		}

		$this->success('删除订单成功！', '/admin/carousel/carouselList');

	}

}