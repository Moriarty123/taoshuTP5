<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use think\Controller;

class Carousel extends Common
{
	public function index()
	{
		return $this->fetch('index');
	}

	public function carouselList()
	{
		$carousel = Db::table('carousel')->select();

		return $this->fetch('carouselList');
	} 

}