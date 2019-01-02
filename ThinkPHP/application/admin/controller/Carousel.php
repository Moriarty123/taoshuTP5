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
		Log::record('显示轮播图列表','notice');

		$carouselList = Db::table('carousel')->paginate(15);
		$carouselNumber = Db::table('carousel')->count();

		$this->assign('carouselList', $carouselList);
		$this->assign('carouselNumber', $carouselNumber);

		return $this->fetch('carouselList');
	} 

	//添加轮播图页面
	public function addPage()
	{
		Log::record('跳转到添加轮播图页面','notice');

		return $this->fetch('carouselAdd');
	}

	//添加轮播图
	public function carouselAdd()
	{
		Log::record('添加轮播图','notice');

		$img = input('post.imgname');
		$path = input('post.path');

		$data = [
			'carousel_img' => $img,
			'carousel_path'=> $path,
			'carousel_state'=>0,
			'add_time'	   => time()
		];

		// dump($data);

		$ret = Db::table('carousel')->insert($data);

		if ($ret == false) {
			$this->error('添加失败！', 'admin/carousel/carouselList');
		}

		$this->success('添加成功！', 'admin/carousel/carouselList');

	}

	//改变状态
	public function changeState()
	{
		Log::record('改变轮播图状态','notice');

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
		Log::record('编辑轮播图状态','notice');

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
		Log::record('模糊搜索','notice');

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

	//删除
	public function carouselDelete()
	{
		Log::record('删除轮播图','notice');

		// dump($_GET);
		$carousel_id = input('get.carousel_id');
		$where = "carousel_id = {$carousel_id}";


		$ret = Db::table('carousel')->where($where)->delete();


		if ($ret == false) {
			$this->error('删除失败！');
		}

		$this->success('删除成功！', '/admin/carousel/carouselList');
	}
	
	//批量删除
	public function checkedcarouselDelete()
	{
		Log::record('批量删除轮播图','notice');
		// dump($_POST);
		//TP5的post方法不能提交数组，在表单name添加/a表示要提交有关数组，获取时同样要添加/a
		$ids = input('post.ids/a');
		// dump($ids);
		// $count = count($ids);

		foreach ($ids as $key => $id) {
			$where = "carousel_id = {$id}";
			//暂时取消外链，删除后恢复
			Db::query('SET FOREIGN_KEY_CHECKS = 0;');
			$ret = Db::table('carousel')->where($where)->delete();
			Db::query('SET FOREIGN_KEY_CHECKS = 1;');
		}

		$this->success('删除成功！', '/admin/carousel/carouselList');

	}

}