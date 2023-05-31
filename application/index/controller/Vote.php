<?php
namespace app\index\controller;
use think\Controller;

/**
 * 投票
 */
class Vote extends Controller
{

	/**
	 * 首页
	 */
	public function index()
	{
		return $this->fetch();
	}


	/**
	 * 投票
	 * @param vid type ip
	 */
	public function Vote()
	{
		$data = input('post.');
		if (!empty($data)) {

			$data['ip'] = get_ip();	//获取Ip

			// 先检测当前ip是否已经投过票
			$count = model('Vote')->checkIp($data);

			// 检测是否提交了type,提交了即代表点击了按钮,没提交即代表页面初次渲染
			if (!empty($data['type'])) {
				if ($count == '0') {	//当前还未投过票 

					// 更新票数  添加用户ip表
					$res = model('Vote')->postVote($data);

					if ($res) {
						
						// 投票成功  获取当前各自的票数
						$info = $this->getPercent($data);
						return return_succ($info);
					}else{
						return return_error('投票失败');
					}
				}else{
					// 已经投过票
					return return_error('您已经投过票了');
				}
			}else{
				// 初次渲染,获取初始数据
				$info = $this->getPercent($data);
				return return_succ($info);
			}
		}else{
			return return_error('数据不能为空');
		}

	}

	// 计算比例
	public function getPercent($data)
	{
		// 投票成功  获取当前各自的票数
		$info = model('Vote')->getInfo($data);
		// 计算比例 保留3位小数
		$info['red_percent'] = round($info['rednum'] / ($info['rednum'] + $info['bluenum']),3);
		$info['blue_percent'] = 1 - $info['red_percent'];
		return $info;
	}


}