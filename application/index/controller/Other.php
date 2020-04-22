<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

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

	public function patient()
	{
		$list = Db::query("select p.pid,p.name,v.days,v.visit_date from patient p join visit v on p.pid = v.patient_id");
		echo "<pre>";
		// print_r($list);
		$newlist = array();
		foreach ($list as $key => $value) {

			$i = 0;
			do {
				
				$value['date'] = date("Y-m-d",strtotime($i." day",strtotime($value['visit_date'])));
				$newlist[] = $value;
				$i++;

			} while ($i < $value['days']);
		}
		print_r($newlist);
	}

	
}