<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Vote extends Model
{
	// 检测当前ip是否已经投过票
	public function checkIp($data)
	{
		$res = Db::table('votes_ip')->where(['vid'=>$data['vid'],'ip'=>$data['ip']])->count();
		return $res;
	}

	// 投票
	public function postVote($data)
	{
		$info = $this->getInfo($data);
		if ($info) {

			Db::startTrans();
			try {
				
				if ($data['type'] == "red") {

					// 更新票数表  
					Db::table('votes')->where(['id'=>$data['vid']])->update(['rednum'=>$info['rednum']+1]);
				}elseif ($data['type'] == "blue") {

					Db::table('votes')->where(['id'=>$data['vid']])->update(['bluenum'=>$info['bluenum']+1]);
				}
				// 添加用户投票ip
				Db::table('votes_ip')->insert(['vid'=>$data['vid'],'ip'=>$data['ip']]);

				Db::commit();
				return true;
			} catch (Exception $e) {
				Db::rollback();
				return false;
			}
		}
	}

	// 获取当前各自的票数
	public function getInfo($data)
	{
		// 获取各自的票数
		$info = Db::table('votes')->where(['id'=>$data['vid']])->find();
		return $info;
	}

}