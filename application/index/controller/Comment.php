<?php
namespace app\index\controller;
use think\Controller;

/**
 * 无限级评论回复
 */
class Comment extends Controller
{

	// 首页
	public function index()
	{
		$num = model('Comment')->getCountCom();
		$list = array();
		// 获取评论列表
		$list = $this->getCommlist();
		
		$this->assign(['num'=>$num,'commlist'=>$list]);
		return $this->fetch();
	}

	/**
	 * 递归获取评论列表
	 */
	public function getCommlist($parent_id = 0,&$result = array())
	{
		$list = model('Comment')->getCommlist($parent_id);
		if (empty($list)) {
			return array();
		}
		foreach ($list as $key => $value) {
			$thisArr = &$result[];
			$value['children'] = $this->getCommlist($value['id'],$thisArr);
			$thisArr = $value;
		}
		return $result;
	}

	/**
	 * 添加评论
	 */
	public function addComment(){			
	   	$data=array();
	   	if((isset($_POST["comment"]))&&(!empty($_POST["comment"]))){
	   		$cm = json_decode($_POST["comment"],true);//通过第二个参数true，将json字符串转化为键值对数组
	   		$cm['create_time'] = $_SERVER['REQUEST_TIME'];
	   		$data['id'] = model('Comment')->addComment($cm);

	   		$data['num'] =  model('Comment')->getCountCom();//统计评论总数

	   	}else{
	   		$data["error"] = "0";
	   	}
	   	

	   	echo json_encode($data);
    }

}