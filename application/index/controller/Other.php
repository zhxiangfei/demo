<?php
namespace app\index\controller;
use think\Controller;

/**
 * 其他
 */
class Other extends Controller
{
	// 回车标签
	public function Tags()
	{
		return $this->fetch();
	}

	
}