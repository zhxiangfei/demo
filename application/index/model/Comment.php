<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Comment extends Model
{
	// 获取评论列表
	public function getCommlist($parent_id)
	{
		$list = Db::table('comment')->where(['parent_id'=>$parent_id])->order("create_time asc")->select();
		return $list;
	}

	// 计算总评论数
	public function getCountCom()
	{
		$res = Db::table('comment')->count();
		return $res;
	}

	// 添加评论
	public function addComment($data)
	{
		$res = Db::table('comment')->insert($data);
		return $res;
	}

}