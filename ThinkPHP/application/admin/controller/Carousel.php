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

}