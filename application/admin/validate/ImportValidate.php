<?php
namespace app\school\validate;

use think\Validate;

/**
 * 个人中心验证
 */
class ImportValidate extends Validate
{
	protected $rule = [
        'tel'  =>  'require|number|checkPhone',
        'period' => 'require|number',
        'price' => 'require|number',
        'max_num' => 'require|number',
    ];

   protected $message = [
        'tel' =>  '手机号',
        'period' =>  '课时',
        'price' => '收费金额',
        'max_num' => '满班人数',
    ];

    protected $scene = [
        'student'  =>  ['period','tel'],
        'course'  =>  ['price','period'],
        'grade'  =>  ['max_num'],
    ];

    //自定义验证规格
    protected function checkPhone($value){

        //匹配正则表达式函数       
        if(preg_match('/^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8])|(19[7]))\d{8}$/',$value)){
            return true;
        }else{
            return  '手机号';
        }
   }


}