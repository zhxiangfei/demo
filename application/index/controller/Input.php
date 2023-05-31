<?php
namespace app\index\controller;
use think\Controller;

class Input extends Controller
{

	public function index()
	{
		return $this->fetch();
	}

}