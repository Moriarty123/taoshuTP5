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

}